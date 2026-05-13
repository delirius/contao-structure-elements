<?php

declare(strict_types=1);

// src/EventListener/parseBackendTemplate.php
namespace Delirius\ContaoStructureElements\EventListener;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FormFieldModel;
use Contao\Input;

class parseBackendTemplateListener
{
	#[AsHook('parseBackendTemplate', priority: 100)]
	/*
	Struktur-Elemente können auf verschiedenen Arten kopiert werden (Seite, Inhalt, Mehrfach-Bearbeitung). 
	Mit Hilfe von strc_pairing und strc_pairing_update werden die zugehörigen Start- und Stop-Elemente neu zugeordnet.
	*/
	public function onparseBackendTemplate(string $buffer, string $template): string
	{
		if ('be_main' !== $template) {
			return $buffer;
		}

		$table = Input::get('table');

		if ($table === 'tl_content') {
			$this->repairOrphanedPairings(ContentModel::class, 'structure_start');
		} elseif ($table === 'tl_form_field') {
			$this->repairOrphanedPairings(FormFieldModel::class, 'form_structure_start');
		}

		return $buffer;
	}

	/**
	 * Findet die zugehörigen Stop-Elemente anhand von strc_pairing_update und verknüpft sie.
	 *
	 * @param class-string $modelClass
	 */
	private function repairOrphanedPairings(string $modelClass, string $type): void
	{
		// Start-Elemente ohne gesetztes strc_pairing laden
		$objStarts = $modelClass::findBy(['type=?', 'strc_pairing=?'], [$type, '']);
		if ($objStarts === null) {
			return;
		}

		foreach ($objStarts as $objStart) {
			if (!$objStart->strc_pairing_update) {
				continue;
			}

			// Zugehörige Stop-Elemente ohne Pairing anhand von strc_pairing_update finden
			$objOrphans = $modelClass::findBy(
				['strc_pairing=?', 'strc_pairing_update=?'],
				[0, $objStart->strc_pairing_update]
			);

			if ($objOrphans === null) {
				continue;
			}

			foreach ($objOrphans as $objOrphan) {
				$objOrphan->strc_pairing        = $objStart->id;
				$objOrphan->strc_pairing_update = $objStart->id;
				$objOrphan->save();
			}
		}
	}
}
