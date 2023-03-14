<?php
// src/EventListener/parseBackendTemplate.php
namespace Delirius\ContaoStructureElements\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\System;
use Contao\Input;

class parseBackendTemplateListener {
	#[AsHook('parseBackendTemplate', priority: 100)]
	public function onparseBackendTemplate(string $buffer, string $template): string {
		if ('be_main' === $template) {

			if (Input::get('do') == 'article') {
				// Get the database connection
				$db = System::getContainer()->get('database_connection');

				// Update tl_content
				$query = 'SELECT id,strc_pairing_update FROM tl_content WHERE type=? AND strc_pairing = "" ';
				$stmt = $db->executeQuery($query, ['structure_start']);
				if ($stmt->rowCount() > 0) {

					while (false !== ($row = $stmt->fetchAssociative())) {
						if ($row['strc_pairing_update']) {

							$arrArg = array();
							$arrArg[] = 'strc_pairing=' . $row['id'] . '';
							$arrArg[] = 'strc_pairing_update=' . $row['id'] . '';

							$queryUpdate = 'UPDATE tl_content SET ' . implode(',', $arrArg) . ' WHERE strc_pairing = 0 AND strc_pairing_update = ?';
							$db->executeQuery($queryUpdate, [$row['strc_pairing_update']]);
						}
					}
				}
			} elseif (Input::get('do') == 'form') {
				// Get the database connection
				$db = System::getContainer()->get('database_connection');

				// Update tl_form_field
				$query = 'SELECT id,strc_pairing_update FROM tl_form_field WHERE type=? AND strc_pairing = "" ';
				$stmt = $db->executeQuery($query, ['form_structure_start']);
				if ($stmt->rowCount() > 0) {

					while (false !== ($row = $stmt->fetchAssociative())) {
						if ($row['strc_pairing_update']) {

							$arrArg = array();
							$arrArg[] = 'strc_pairing=' . $row['id'] . '';
							$arrArg[] = 'strc_pairing_update=' . $row['id'] . '';

							$queryUpdate = 'UPDATE tl_form_field SET ' . implode(',', $arrArg) . ' WHERE strc_pairing = 0 AND strc_pairing_update = ?';
							$db->executeQuery($queryUpdate, [$row['strc_pairing_update']]);
						}
					}
				}

			}
		}
		return $buffer;
	}
}

?>