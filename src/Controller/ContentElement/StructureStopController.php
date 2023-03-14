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

namespace Delirius\ContaoStructureElements\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Delirius\ContaoStructureElements\BackendHelper\Helper;

#[AsContentElement(category: 'structure_elements', template: 'ce_structure_stop')]
class StructureStopController extends AbstractContentElementController {
	public const TYPE = 'structure_stop';

	protected function getResponse(Template $template, ContentModel $model, Request $request): Response{

		$strHtml = '</';
		$strHtml .= $model->strc_element . ' ';
		$strHtml .= '>';

		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
			$strHtml = Helper::generateBackendDesign('stop', $model->strc_color, $model->strc_title, $model->strc_element);
		}

		// $template->text = $model->text;
		$template->html = $strHtml;

		return $template->getResponse();
	}
}
