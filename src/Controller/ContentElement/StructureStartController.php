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
use Contao\Config;
use Contao\Input;
use Contao\Template;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Delirius\ContaoStructureElements\BackendHelper\Helper;

#[AsContentElement(category: 'structure_elements', template: 'ce_structure_start')]
class StructureStartController extends AbstractContentElementController {
	public const TYPE = 'structure_start';

	protected function getResponse(Template $template, ContentModel $model, Request $request): Response{

		$arrAttr = array();

		if ($model->cssID) {
			$arrCss = StringUtil::deserialize($model->cssID);
			if ($arrCss[0] != '') {
				// id
				$arrAttr[] = 'id="' . $arrCss[0] . '"';
			}
			if ($arrCss[1] != '') {
				// id
				$arrAttr[] = 'class="' . $arrCss[1] . '"';
			}
		}
		if ($model->strc_element_attribute) {
			$arrAdd = StringUtil::deserialize($model->strc_element_attribute);

			if (is_array($arrAdd) && count($arrAdd) > 0) {
				foreach ($arrAdd as $value) {
					if (!$value || is_array($value)) {continue;}
					$arrAttr[] = trim($value);
				}
			}
		}

		$strHtml = '<';
		$strHtml .= html_entity_decode($model->strc_element);

		if (is_array($arrAttr) && count($arrAttr) > 0) {
			$strAttr = html_entity_decode(implode(' ', $arrAttr));
			$strHtml .= ' ' . StringUtil::encodeEmail((string) $strAttr);
		}
		$strHtml .= '>';

		if ($model->strc_content) {
			$strHtml .= StringUtil::encodeEmail((string) $model->strc_content);
		}

		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
			$strHtml = Helper::generateBackendDesign('start', $model->strc_color, $model->strc_title, $model->strc_element, $model->strc_content, $arrAttr);
		}

		// $template->text = $model->text;
		$template->html = Input::stripTags($strHtml, Config::get('allowedTags'), Config::get('allowedAttributes'));

		return $template->getResponse();
	}
}
