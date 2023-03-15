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

/**
 * Content elements
 */

use Delirius\ContaoStructureElements\Widget\Frontend\FormStructureStart;
use Delirius\ContaoStructureElements\Widget\Frontend\FormStructureStop;

$GLOBALS['TL_DCA']['tl_form_field']['palettes'][FormStructureStart::TYPE] = '{type_legend},type; {structurespec_legend},strc_title,strc_color; {structure_legend},strc_element,class,strc_element_attribute,strc_content; {template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_form_field']['palettes'][FormStructureStop::TYPE] = '';

$GLOBALS['TL_DCA']['tl_form_field']['config']['onsubmit_callback'][] = array('\Delirius\ContaoStructureElements\BackendHelper\Helper', 'onsubmitCallback');
$GLOBALS['TL_DCA']['tl_form_field']['config']['ondelete_callback'][] = array('\Delirius\ContaoStructureElements\BackendHelper\Helper', 'ondeleteCallback');

$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_title'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'text',
	'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_color'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'text',
	'eval' => array('maxlength' => 6, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard'),
	'sql' => "varchar(6) NOT NULL default ''",

);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_element'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'search' => true,
	'filter' => true,
	'sorting' => true,
	'inputType' => 'text',
	'eval' => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_pairing'] = array(
	'inputType' => 'text',
	'eval' => array('doNotCopy' => true, 'tl_class' => 'w50 clr'),
	'sql' => "int(10) unsigned NOT NULL default '0'",

);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_pairing_update'] = array(
	'inputType' => 'text',
	'eval' => array('tl_class' => 'w50'),
	'sql' => "int(10) unsigned NOT NULL default '0'",

);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_element_attribute'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'inputType' => 'listWizard',
	'sql' => "blob NULL",
	'eval' => array(
		'tl_class' => 'clr',
		'maxlength' => 128,
		'decodeEntities' => true,
	),

);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['strc_content'] = array(
	'exclude' => true, // Zugang fuer Benutzer
	'inputType' => 'text',
	'eval' => array('maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50 clr'),
	'sql' => "varchar(255) NOT NULL default ''",

);
