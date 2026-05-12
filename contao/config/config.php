<?php

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

// /**
//  * Wrapper
//  */

$GLOBALS['TL_WRAPPERS']['start'][] = StructureStartController::TYPE;
$GLOBALS['TL_WRAPPERS']['stop'][] = StructureStopController::TYPE;
$GLOBALS['TL_WRAPPERS']['start'][] = FormStructureStart::TYPE;
$GLOBALS['TL_WRAPPERS']['stop'][] = FormStructureStop::TYPE;

//$GLOBALS['BE_FFL']['form_structure_start'] = FormStructureStart::class;

$GLOBALS['TL_FFL'][FormStructureStart::TYPE] = FormStructureStart::class;
$GLOBALS['TL_FFL'][FormStructureStop::TYPE] = FormStructureStop::class;
