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
use Delirius\ContaoStructureElements\Widget\Frontend\FormStructureStart;
use Delirius\ContaoStructureElements\Widget\Frontend\FormStructureStop;
/**
 * Content element
 */
$GLOBALS['TL_LANG']['CTE']['structure_elements'] = 'Struktur Elemente';
$GLOBALS['TL_LANG']['CTE'][StructureStartController::TYPE] = ['Struktur Start Element', ''];
$GLOBALS['TL_LANG']['CTE'][StructureStopController::TYPE] = ['Struktur Stop Element', ''];

$GLOBALS['TL_LANG']['FFL'][FormStructureStart::TYPE] = array('Struktur Start Element', '');
$GLOBALS['TL_LANG']['FFL'][FormStructureStop::TYPE] = array('Struktur Stop Element', '');

/**
 * Miscellaneous
 */
//$GLOBALS['TL_LANG']['MSC'][''] = '';

/**
 * Errors
 */
//$GLOBALS['TL_LANG']['ERR'][''] = '';
