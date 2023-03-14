<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Delirius\ContaoStructureElements\Widget\Frontend;
use Contao\Widget;
use Contao\System;
use Contao\StringUtil;
use Contao\BackendTemplate;
use Delirius\ContaoStructureElements\BackendHelper\Helper;

/**
 * Class FormExplanation
 *
 * @property string $text
 */
class FormStructureStart extends Widget {

	public const TYPE = 'form_structure_start';

//echo 'inside FormStructureStart '; exit;
	/**
	 * Template
	 *
	 * @var string
	 */
	protected $strTemplate = 'form_structureStart';

	/**
	 * The CSS class prefix
	 *
	 * @var string
	 */
	protected $strPrefix = 'widget widget-structure';
	protected $attr = '';

	/**
	 * Do not validate
	 */
	public function validate() {
	}

	public function parse($arrAttributes = null) {
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
			$arrAttr = array();

			if ($this->class) {
				$arrAttr[] = 'class="' . $this->class . '"';
			}
			if ($this->strc_element_attribute) {
				$arrAdd = StringUtil::deserialize($this->strc_element_attribute);

				if (is_array($arrAdd) && count($arrAdd) > 0) {
					foreach ($arrAdd as $value) {

						if (!$value) {continue;}
						if (is_array($value)) {continue;}

						$arrAttr[] = html_entity_decode(trim($value . ''));

					}
				}
			}

			$strHtml = Helper::generateBackendDesign('start', $this->strc_color, $this->strc_title, $this->strc_element, $this->strc_content, $arrAttr);

			$objTemplate = new BackendTemplate('be_wildcard');
			//$objTemplate->title = $this->strc_title ;
			//$objTemplate->wildcard = '### ' . $this->strc_title . $this->class . ' ###';
			$objTemplate->description = $strHtml;

			return $objTemplate->parse();
		}

		return parent::parse($arrAttributes);
	}

	/**
	 * Generate the widget and return it as string
	 *
	 * @return string The widget markup
	 */
	public function generate() {

		$arrAttr = array();

		if ($this->strc_element_attribute) {
			$arrAdd = StringUtil::deserialize($this->strc_element_attribute);

			if (is_array($arrAdd) && count($arrAdd) > 0) {
				foreach ($arrAdd as $value) {

					if (!$value) {continue;}
					if (is_array($value)) {continue;}

					$arrAttr[] = html_entity_decode(trim($value . ''));
				}
			}
		}
		if (is_array($arrAttr) && count($arrAttr) > 0) {
			$this->attr = ' ' . implode(' ', $arrAttr);
		}

		return sprintf(
			'<%s class="%s"%s>%s',
			$this->strc_element,
			$this->prefix . ($this->class ? ' ' . $this->class : ''),
			$this->attr,
			html_entity_decode($this->strc_content),
		);
	}
}

class_alias(FormStructureStart::class, 'FormStructureStart');
