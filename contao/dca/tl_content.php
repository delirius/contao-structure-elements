<?php

declare (strict_types = 1);

/*
 * This file is part of Structure elements.
 *
 * (c) Daniel Herren 2023 <contao@delirius.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/delirius/contao-structure-elements
 */

use Delirius\ContaoStructureElements\Controller\ContentElement\StructureStartController;
use Delirius\ContaoStructureElements\Controller\ContentElement\StructureStopController;

/**
 * Content elements
 */
//$GLOBALS['TL_DCA']['tl_content']['palettes'][StructureStartController::TYPE] = '{type_legend},type,headline;{text_legend},text;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes'][StructureStartController::TYPE] = '{type_legend},type; {structurespec_legend},strc_title,strc_color; {structure_legend},strc_element,cssID,strc_element_attribute,strc_content; {template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_content']['palettes'][StructureStopController::TYPE] = '';

$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('\Delirius\ContaoStructureElements\BackendHelper\Helper', 'onsubmitCallback');
$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = array('\Delirius\ContaoStructureElements\BackendHelper\Helper', 'ondeleteCallback');

$GLOBALS['TL_DCA']['tl_content']['fields']['strc_title'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'text',
	'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);
$GLOBALS['TL_DCA']['tl_content']['fields']['strc_color'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'text',
	'eval' => array('maxlength' => 6, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard'),
	'sql' => "varchar(6) NOT NULL default ''",

);
// $GLOBALS['TL_DCA']['tl_content']['fields']['strc_element'] = array(
// 	'exclude' => true, // Zugang fuer Benutzer
// 	'search' => true,
// 	'filter' => true,
// 	'sorting' => true,
// 	'inputType' => 'text',
// 	'eval' => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50 clr'),
// 	'sql' => "varchar(255) NOT NULL default ''",

// );
$GLOBALS['TL_DCA']['tl_content']['fields']['strc_element'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'select',
	'options' => array(
		'div',
		'span',
		'a',
		'button',
		'br',
		'hr',
		'i',
		'ol',
		'ul',
		'li',
		'article',
		'aside',
		'details',
		'footer',
		'header',
		'nav',
		'section',
		'summary',
	),

	'eval' => array('mandatory' => true, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);

$GLOBALS['TL_DCA']['tl_content']['fields']['strc_pairing'] = array(
	'inputType' => 'text',
	'eval' => array('doNotCopy' => true, 'tl_class' => 'w50 clr'),
	'sql' => "int(10) unsigned NOT NULL default '0'",

);
$GLOBALS['TL_DCA']['tl_content']['fields']['strc_pairing_update'] = array(
	'inputType' => 'text',
	'eval' => array('tl_class' => 'w50'),
	'sql' => "int(10) unsigned NOT NULL default '0'",

);

$GLOBALS['TL_DCA']['tl_content']['fields']['strc_element_attribute'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'inputType' => 'listWizard',
	'sql' => "blob NULL",
	'eval' => array(
		'tl_class' => 'clr',
		'maxlength' => 128,
	),

);
$GLOBALS['TL_DCA']['tl_content']['fields']['strc_content'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'inputType' => 'text',
	'eval' => array('maxlength' => 255, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);
