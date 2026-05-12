<?php

declare (strict_types = 1);

namespace Delirius\ContaoStructureElements\BackendHelper;
use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\FormFieldModel;

/**
 * Generall Helper Class for Backend
 */
class Helper {

	#[AsCallback(table: 'tl_content', target: 'config.onsubmit')]
	#[AsCallback(table: 'tl_form_field', target: 'config.onsubmit')]
	public function onsubmitCallback(DataContainer $dc): void
	{
		$validTypes = ['structure_start', 'structure_stop', 'form_structure_start', 'form_structure_stop'];
		if (!in_array($dc->activeRecord->type, $validTypes, true)) {
			return;
		}

		$this->table = $dc->table;
		if (!$this->table || !in_array($this->table, ['tl_content', 'tl_form_field'], true)) {
			return;
		}

		$modelClass = $this->getModelClass();

		$id   = (int) $dc->activeRecord->id;
		$type = $dc->activeRecord->type;

		if ($type === 'structure_start' || $type === 'form_structure_start') {

			// Defaults auf dem Start-Element sicherstellen, ohne rohe SQL-Strings
			$objSelf = $modelClass::findById($id);
			if ($objSelf !== null) {
				$changed = false;

				if ((int) $objSelf->strc_pairing === 0 || (int) $objSelf->strc_pairing !== $id) {
					$objSelf->strc_pairing        = $id;
					$objSelf->strc_pairing_update = $id;
					$changed = true;
				}
				if ($objSelf->strc_color === '') {
					$objSelf->strc_color = static::randomColor();
					$changed = true;
				}
				if ($objSelf->strc_element === '') {
					$objSelf->strc_element = 'div';
					$changed = true;
				}
				if ($changed) {
					$objSelf->save();
				}
			}

			if ($this->getPairingId($id) === 0) {
				$this->createPairing($id, $type);
			}
			$this->updatePairing($id);
		}

		if ($type === 'structure_stop' || $type === 'form_structure_stop') {
			if ($this->getPairingId($id) === 0) {
				$this->createPairing($id, $type);
			}
			$this->updatePairing($id);
		}
	}

	#[AsCallback(table: 'tl_content', target: 'config.ondelete')]
	#[AsCallback(table: 'tl_form_field', target: 'config.ondelete')]
	public function ondeleteCallback(DataContainer $dc): void
	{
		$validTypes = ['structure_start', 'structure_stop', 'form_structure_start', 'form_structure_stop'];
		if (!in_array($dc->activeRecord->type, $validTypes, true)) {
			return;
		}

		$this->table = $dc->table;
		if (!$this->table || !in_array($this->table, ['tl_content', 'tl_form_field'], true)) {
			return;
		}

		$this->deletePairing((int) $dc->activeRecord->strc_pairing);
	}

	public function updatePairing(int $id): void
	{
		if ($id === 0) {
			return;
		}

		$modelClass = $this->getModelClass();
		if ($modelClass === null) {
			return;
		}

		// Quell-Element (Start) laden, um die zu synchronisierenden Werte zu lesen
		$objSource = $modelClass::findById($id);
		if ($objSource === null) {
			return;
		}

		// Alle Partner mit derselben strc_pairing-ID laden und Felder synchronisieren.
		// Kein String-Konkatenation, kein SQL-Injection-Risiko mehr.
		$objPartners = $modelClass::findBy('strc_pairing', $id);
		if ($objPartners === null) {
			return;
		}

		foreach ($objPartners as $objPartner) {
			$objPartner->strc_title          = $objSource->strc_title;
			$objPartner->strc_color          = $objSource->strc_color;
			$objPartner->strc_element        = $objSource->strc_element;
			$objPartner->strc_pairing_update = $objSource->strc_pairing_update;
			$objPartner->save();
		}
	}

	public function createPairing(int $id, string $type): ?int
	{
		if ($id === 0) {
			return null;
		}

		$modelClass = $this->getModelClass();
		if ($modelClass === null) {
			return null;
		}

		// Aktuelles Element laden
		$objCurrent = $modelClass::findById($id);
		if ($objCurrent === null) {
			return null;
		}

		// Fallback: Wenn ein Stop-Element zuerst gespeichert wurde, wird es nachträglich in ein Start-Element umgewandelt
		if ($type === 'structure_stop' || $type === 'form_structure_stop') {
			$objCurrent->type               = str_replace('stop', 'start', $type);
			$objCurrent->strc_element       = $objCurrent->strc_element ?: 'div';
			$objCurrent->strc_color         = $objCurrent->strc_color    ?: static::randomColor();
			$objCurrent->strc_pairing       = $id;
			$objCurrent->strc_pairing_update = $id;
			$objCurrent->save();
		}

		// Das zugehörige Stop-Element erstellen.
		// id aus dem Row-Array entfernen, damit setRow() keinen Registry-Konflikt auslöst
		// Ohne id im Row führt save() automatisch ein INSERT aus.
		$row = $objCurrent->row();
		unset($row['id']);

		$objStop = new $modelClass();
		$objStop->setRow($row);
		$objStop->type                = str_replace('start', 'stop', $type);
		$objStop->sorting             = (int) $objCurrent->sorting + 1;
		$objStop->strc_pairing        = $id;
		$objStop->strc_pairing_update = $id;
		$objStop->tstamp              = time();
		$objStop->save();

		return (int) $objStop->id;
	}

	public function deletePairing(int $pairid): void
	{
		if ($pairid === 0) {
			return;
		}

		$modelClass = $this->getModelClass();
		if ($modelClass === null) {
			return;
		}

		// Alle zusammengehörigen Elemente laden und einzeln löschen.
		// Model->delete() entfernt den Datensatz und deregistriert ihn aus dem Registry.
		$objElements = $modelClass::findBy('strc_pairing', $pairid);
		if ($objElements === null) {
			return;
		}

		foreach ($objElements as $objElement) {
			$objElement->delete();
		}
	}

	public function getPairingId(int $id): int
	{
		if ($id === 0) {
			return 0;
		}

		$modelClass = $this->getModelClass();
		if ($modelClass === null) {
			return 0;
		}

		// Schritt 1: strc_pairing des aktuellen Elements lesen
		$objCurrent = $modelClass::findById($id);
		if ($objCurrent === null) {
			return 0;
		}

		$pairingId = (int) $objCurrent->strc_pairing;
		if ($pairingId === 0) {
			return 0;
		}

		// Schritt 2: Prüfen ob mindestens ein anderes Element mit dieser strc_pairing-ID existiert.
		// Nur dann ist das Pairing vollständig (Start + Stop vorhanden).
		$objPaired = $modelClass::findBy('strc_pairing', $pairingId);
		if ($objPaired !== null && $objPaired->count() > 1) {
			return $pairingId;
		}

		return 0;
	}

	/**
	 * Gibt die Model-Klasse für $this->table zurück, oder null für unbekannte Tabellen.
	 */
	private function getModelClass(): ?string
	{
		return match ($this->table) {
			'tl_content'    => ContentModel::class,
			'tl_form_field' => FormFieldModel::class,
			default         => null,
		};
	}

	public static function randomColor() {

		$arrColor = array();
		$arrColor[] = '990000';
		$arrColor[] = 'cc3300';
		$arrColor[] = '666600';
		//   $arrColor[] = 'ffcc33'; // orangegelb
		$arrColor[] = '336600';
		$arrColor[] = '0066cc';
		$arrColor[] = '0033cc';
		$arrColor[] = '6600cc';
		$arrColor[] = '990099';
		$arrColor[] = '777777';

		$count = count($arrColor) - 1;
		$rand = rand(0, $count);

		if (false) {
			$str = '';
			foreach ($arrColor as $color) {
				$str .= "<br><span style='color:#" . $color . "'>● " . $color . "</span> ";
			}
			echo '<pre>' . htmlspecialchars($str) . '</pre>';exit;

		}

		return $arrColor[$rand];

	}

	public static function generateBackendDesign($symbol = 'start', $color = '#ccff55', $title = 'Title', $element = 'div', $content = '', $arrAttr = array()) {

		if ($symbol == 'start') {
			// $uni = '▼';
			// $uni = '●';
			$uni = '↓';

			$strHtml = '<span style="color:#' . $color . '">' . $uni . '</span> ';
			$strHtml .= '<strong>' . $title . '</strong> ';
			$strHtml .= '<span style="color:#999">';
			$strHtml .= $element . ' ';
			if (is_array($arrAttr) && count($arrAttr) > 0) {
				$strHtml .= implode(' ', $arrAttr);
			}
			$strHtml .= '</span>';
			if ($content !== '') {
				$strHtml .= ' ' . html_entity_decode($content);
			}

		} else {
			// $uni = '▲';
			// $uni = '●';
			$uni = '↑';
			$strHtml = '<span style="color:#' . $color . '">' . $uni . '</span> ';
			$strHtml .= '<strong>' . $title . '</strong> ';
			$strHtml .= '<span style="color:#999">';
			$strHtml .= '/' . $element;
			$strHtml .= '</span> ';

		}

		return $strHtml;
	}

}
