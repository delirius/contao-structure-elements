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
use Contao\BackendTemplate;
use Delirius\ContaoStructureElements\BackendHelper\Helper;

/**
 * Class FormExplanation
 *
 * @property string $text
 */
class FormStructureStop extends Widget {

	public const TYPE = 'form_structure_stop';

//echo 'inside FormStructureStart '; exit;
	/**
	 * Template
	 *
	 * @var string
	 */
	protected $strTemplate = 'form_structureStop';

	/**
	 * The CSS class prefix
	 *
	 * @var string
	 */
	protected $strPrefix = 'widget widget-structure';

	/**
	 * Do not validate
	 */
	public function validate() {
	}

	public function parse($arrAttributes = null) {
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {

			$strHtml = Helper::generateBackendDesign('stop', $this->strc_color, $this->strc_title, $this->strc_element);

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
		return sprintf(
			'</%s>',
			$this->strc_element
		);
	}
}

class_alias(FormStructureStop::class, 'FormStructureStop');
