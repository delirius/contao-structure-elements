<?php
// src/EventListener/DisableButtonCallback.php
namespace Delirius\ContaoStructureElements\EventListener;

use Contao\Backend;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;

#[AsCallback(table: 'tl_content', target: 'list.operations.edit.button'), AsCallback(table: 'tl_content', target: 'list.operations.copy.button'), AsCallback(table: 'tl_content', target: 'list.operations.cut.button'), AsCallback(table: 'tl_form_field', target: 'list.operations.edit.button'), AsCallback(table: 'tl_form_field', target: 'list.operations.copy.button'), AsCallback(table: 'tl_form_field', target: 'list.operations.cut.button')]
class DisableButtonCallback {

	public function __invoke(
		array $row,
		?string $href,
		string $label,
		string $title,
		?string $icon,
		string $attributes,
		string $table,
		array $rootRecordIds,
		?array $childRecordIds,
		bool $circularReference,
		?string $previous,
		?string $next,
		DataContainer $dc

	): string {

		if ($row['type'] === 'structure_stop' || $row['type'] === 'form_structure_stop') {
			return '';
		}
		return sprintf(
			'<a href="%s" title="%s"%s>%s</a> ',
			Backend::addToUrl($href . '&amp;id=' . $row['id']),
			StringUtil::specialchars($title),
			$attributes,
			Image::getHtml($icon, $label)
		);
	}
	//$GLOBALS['TL_DCA']['tl_content']['fields']['text']['eval']['mandatory'] = false;

}
