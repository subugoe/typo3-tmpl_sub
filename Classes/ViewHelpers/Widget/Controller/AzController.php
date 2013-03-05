<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ingo Pfennigstorf <i.pfennigstorf@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * A - Z Index generator and lister
 *
 * @author Ingo Pfennigstorf <i.pfennigstorf@gmail.com>
 * @package TmplSub
 * @subpackage ViewHelpers/Widget
 */
class Tx_TmplSub_ViewHelpers_Widget_Controller_AzController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @var array
	 */
	protected $configuration = array(
		'titleField' => 'title',
		'linkObject' => '',
		'linkAction' => '',
		'linkController' => '',
		'linkPluginName' => '',
		'linkExtensionName' => ''
	);

	/**
	 * @var Tx_Extbase_Persistence_QueryResultInterface
	 */
	protected $objects;

	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->objects = $this->widgetConfiguration['objects'];
		$this->configuration = t3lib_div::array_merge_recursive_overrule($this->configuration, $this->widgetConfiguration['configuration'], TRUE);
	}

	/**
	 * Generate titles, indexes and assign this to the view
	 *
	 * @return void
	 */
	public function indexAction() {

		$groupings = $this->getAzGrouping($this->objects);

		$this->view->assignMultiple(
			array (
				'titles' => $groupings,
				'linkObject' => $this->configuration['linkObject'],
				'linkAction' => $this->configuration['linkAction'],
				'linkController' => $this->configuration['linkController'],
				'linkPluginName' => $this->configuration['linkPluginName'],
				'linkExtensionName' => $this->configuration['linkExtensionName']
			)
		);
	}

	/**
	 * Groups the titles to their indexes
	 *
	 * @param $titles
	 * @return array
	 */
	protected function getAzGrouping($titles) {

		$groupings = array();

		$lastChar = '';
		foreach($titles as $title) {

				// find titleField and get contents
			$objectTitle = Tx_Extbase_Reflection_ObjectAccess::getProperty($title, $this->configuration['titleField']);

			$title->linkObject = array($this->configuration['linkObject'] => $title->getUid());

			$firstLetter = $this->getSpecifiedLetter($objectTitle, 0);

			if ($firstLetter != $lastChar) {
				$groupings[$firstLetter] = array();
			}
			array_push($groupings[$firstLetter], $title);

			$lastChar = $this->getSpecifiedLetter($objectTitle, 0);
		}
		ksort($groupings);
		return $groupings;
	}

	/**
	 * Returns the letter from a given index of a string
	 *
	 * @param $title
	 * @param $index
	 * @return string
	 */
	protected function getSpecifiedLetter($title, $index) {
		return mb_substr(mb_strtoupper(iconv('utf-8', 'ascii//TRANSLIT', $title)), $index, $index + 1, 'utf-8');
	}
}

?>