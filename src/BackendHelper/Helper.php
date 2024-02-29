<?php

declare (strict_types = 1);

namespace Delirius\ContaoStructureElements\BackendHelper;
use Contao\DataContainer;
use Contao\System;

/**
 * Generall Helper Class for Backend
 */
class Helper {

	public function onsubmitCallback(DataContainer $dc) {

		if ( ! in_array($dc->activeRecord->type, array('structure_start', 'structure_stop', 'form_structure_start', 'form_structure_stop'))) {
			return;
		}

		$this->table = $dc->table;

		if ( ! $this->table || ! in_array($this->table, array('tl_content', 'tl_form_field'))) {
			return;
		}

		$this->db = System::getContainer()->get('database_connection');

		$id = $dc->activeRecord->id;
		$type = $dc->activeRecord->type; // structure_start structure_stop

		if ($type === 'structure_start' || $type === 'form_structure_start') {
			$arrArg = array();
			if ($dc->activeRecord->strc_pairing == 0 || $dc->activeRecord->strc_pairing != $id) {
				$arrArg[] = 'strc_pairing=' . $id;
				$arrArg[] = 'strc_pairing_update=' . $id;
			}
			if ($dc->activeRecord->strc_color == '') {
				$arrArg[] = 'strc_color="' . $this->randomColor() . '"';
			}
			if ($dc->activeRecord->strc_element == '') {
				$arrArg[] = 'strc_element="div"';
			}
			if (count($arrArg) > 0) {
				$this->updateSelf($id, $arrArg);
			}

			$pairingID = $this->getPairingId($id);

			if ($pairingID == 0) {
				$this->createPairing($id, $type);
			}

			$this->updatePairing($id);

		}

		if ($type === 'structure_stop' || $type === 'form_structure_stop') {
			$pairingID = $this->getPairingId($id);

			if ($pairingID == 0) {
				$this->createPairing($id, $type);
			}

			$this->updatePairing($id);

		}

	}

	public function ondeleteCallback(DataContainer $dc) {

		if ( ! in_array($dc->activeRecord->type, array('structure_start', 'structure_stop', 'form_structure_start', 'form_structure_stop'))) {
			return;
		}

		$this->table = $dc->table;

		if ( ! $this->table || ! in_array($this->table, array('tl_content', 'tl_form_field'))) {
			return;
		}

		$pairing = $dc->activeRecord->strc_pairing;
		$this->deletePairing($pairing);

	}

	public function updateSelf($id = 0, $arrArg = array()) {

		if ($id == 0 || count($arrArg) < 1) {
			return;
		}

		$query = 'UPDATE ' . $this->table . ' SET ' . implode(',', $arrArg) . ' WHERE id = ?';
		$stmt = $this->db->executeQuery($query, [$id]);
	}

	public function updatePairing($id = 0) {

		if ($id == 0) {
			return;
		}

		$query = 'SELECT strc_title, strc_color,strc_element,strc_pairing_update FROM ' . $this->table . ' WHERE id = ?';
		$stmt = $this->db->executeQuery($query, [$id]);
		$arrRow = $stmt->fetchAllAssociative();

		$arrArg = array();
		if (is_array($arrRow) && count($arrRow) == 1) {
			foreach ($arrRow[0] as $key => $value) {
				$arrArg[] = $key . '="' . $value . '"';
			}
		}

		$query = 'UPDATE ' . $this->table . ' SET ' . implode(',', $arrArg) . ' WHERE strc_pairing = ?';
		$stmt = $this->db->executeQuery($query, [$id]);

	}

	public function createPairing($id = 0, $type = '') {

		if ($id == 0) {
			return;
		}

		if ($type == 'structure_stop' || $type == 'form_structure_stop') {
			// change to start and then create stop
			$arrArg = array();

			$arrArg[] = 'type="' . str_replace('stop', 'start', $type) . '"';
			$arrArg[] = 'strc_element="div"';
			$arrArg[] = 'strc_color="' . $this->randomColor() . '"';
//			$arrArg[] = 'strc_title="New structure element"';
			$arrArg[] = 'strc_pairing=' . $id;
			$arrArg[] = 'strc_pairing_update=' . $id;
			$this->updateSelf($id, $arrArg);
		}

		// copy entry
		// type, pid, ptable, sorting
		// strc_pairing, strc_pairing_update

		if ($type == 'structure_stop') {
			$query = 'SELECT type, pid, ptable, sorting, strc_pairing, strc_pairing_update FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
		} else {
			$query = 'SELECT type, pid, sorting, strc_pairing, strc_pairing_update FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
		}
		$stmt = $this->db->executeQuery($query, [$id]);
		$arrRow = $stmt->fetchAllAssociative();

		$arrRowInsert['type'] = str_replace('start', 'stop', $type);
		$arrRowInsert['pid'] = $arrRow[0]['pid'];
		if ($type == 'structure_stop') {
			$arrRowInsert['ptable'] = $arrRow[0]['ptable'];
		}
		$arrRowInsert['sorting'] = $arrRow[0]['sorting'] + 1;
		$arrRowInsert['strc_pairing'] = $id;
		$arrRowInsert['strc_pairing_update'] = $id;
		$arrRowInsert['tstamp'] = time();

		$queryInsert = " INSERT INTO " . $this->table;
		$queryInsert .= " ( " . implode(", ", array_keys($arrRowInsert)) . ") ";
		$queryInsert .= " VALUES ('" . implode("', '", array_values($arrRowInsert)) . "')";

		$stmt = $this->db->executeQuery($queryInsert, []);
		$lastId = $this->db->lastInsertId();
		return $lastId;
	}

	public function deletePairing($pairid = 0) {

		if ($pairid == 0) {
			return;
		}

		// Get the database connection
		$db = System::getContainer()->get('database_connection');

		// delete
		$query = 'DELETE FROM ' . $this->table . ' WHERE strc_pairing = ?';
		$stmt = $db->executeQuery($query, [$pairid]);
		$stmt->fetchAllAssociative();

	}

	public function getPairingId($id = 0) {

		if ($id == 0) {
			return;
		}

		$query = 'SELECT strc_pairing FROM ' . $this->table . ' WHERE  id = ?';
		$stmt = $this->db->executeQuery($query, [$id]);
		$idPairing = $stmt->fetchOne();

		$query = 'SELECT id FROM ' . $this->table . ' WHERE  strc_pairing = ?';
		$stmt = $this->db->executeQuery($query, [$idPairing]);
		if ($stmt->rowCount() > 1) {
			// $row = $stmt->fetchAssociative();
			return $idPairing;
		} else {
			return 0;
		}
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
