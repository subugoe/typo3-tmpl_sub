<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>, Goettingen State Library
 *  	
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * ************************************************************* */

/**
 * Generates header graphics and licence information
 *
 * @author Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>, Goettingen State Library
 */
class user_template {

	const WIKICOMMONSIMG = 'cc_commons.png';
	const CCIMG = 'nur_cc.png';
	const NURINFOIMG = 'nur_info.png';
	const CCLIZENZ = '';

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $local_cObj;

	/**
	 * @var int
	 */
	protected $page_id;

	/**
	 * Get Big Picture and Copyright Information
	 *
	 * @param $content
	 * @param $conf
	 */
	public function bigPicture($content = '', $conf = array()) {

		global $TSFE;

		$this->local_cObj = $TSFE->cObj; // cObject

		$this->page_id = $GLOBALS['TSFE']->id;

		$results = $this->getBigPictureFromPage($this->page_id);

		$foundCount = count($results);

		if ($foundCount > 0) {
			// use the first result
			$content = $this->formatBigPicture($results[0]);
			$content .= $this->getImageInformation($results[0]);
			$content = '<div id="bigpicture">' . $content . '</div>';
		} elseif ($this->checkRootlineForPics()) {
			// Check rootline to see if we have inherited pics
			$results = $this->getBigPictureFromPage($this->checkRootlineForPics());
			$content = $this->formatBigPicture($results[0]);
			$content .= $this->getImageInformation($results[0]);
			$content = '<div id="bigpicture">' . $content . '</div>';
		}

		return $content;
	}

	/**
	 * Check if there is any inherited Headerimage and stop at the first one in the rootline
	 *
	 * @return bool
	 */
	protected function checkRootlineForPics() {
		$rootline = $GLOBALS['TSFE']->rootLine;
		$return = false;

		foreach ($rootline as $parentPage) {
			if ($parentPage['tx_nkwsubmenu_picture_follow'] === 1 && $parentPage['tx_nkwsubmenu_picture']) {
				return $parentPage['uid'];
				break;
			}
		}
		return $return;
	}

	/**
	 * Gets picture Information out of DAM
	 *
	 * @param $pageId
	 * @return array
	 */
	protected function getBigPictureFromPage($pageId) {

		/** @var \TYPO3\CMS\Core\Resource\FileRepository $fileRepository */
		$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$fileObjects = $fileRepository->findByRelation('pages', 'tx_nkwsubmenu_picture', $pageId);
		$files = array();

		foreach ($fileObjects as $key => $value) {
			$files[$key]['reference'] = $value->getReferenceProperties();
			$files[$key]['original'] = $value->getOriginalFile()->getProperties();
		}

		return $files;
	}

	/**
	 * Renders the image and puts Information to the picture
	 *
	 * @param array $image
	 * @return mixed
	 */
	protected function formatBigPicture($image) {
		$lconf['image.']['params'] = '';
		$lconf['image.']['file.']['treatIdAsReference'] = 1;
		$lconf['image.']['file'] = $image['reference']['uid'];
		$lconf['image.']['altText'] = $image['original']['caption'];
		$lconf['image.']['file.']['height'] = 228;
		$lconf['image.']['file.']['width'] = 1000;
		$theImgCode = $this->local_cObj->IMAGE($lconf["image."]);
		$image = $this->local_cObj->stdWrap($theImgCode, $this->conf['image.']);
		return $image;
	}

	/**
	 * Get license information for the image
	 *
	 * @param array $image
	 * @return string
	 */
	protected function getImageInformation($image) {
		$imageUrl = '';

		$imageTitleText = array();

		$imageTitleText[] = $image['caption'];
		$imageTitleText[] = 'Urheber: ' . $image['original']['creator'];
		$imageTitleText[] = 'Copyright: ' . $image['original']['copyright'];

		$imageTitleText = implode(PHP_EOL, $imageTitleText);

		$licenseImagePath = 'typo3conf/ext/tmpl_sub/Resources/Public/Img';
		if ($image['original']['wiki_commons'] != '') {
			$imagePath = self::WIKICOMMONSIMG;
			$cssClass = 'wc';
			$imageUrl = $image['original']['copyright_url'];
			$imageTitleText .= "\n" . $image['original']['wiki_commons'];
		} elseif ($image['original']['creative_commons'] == 1 && $image['original']['wiki_commons'] == '') {
			$imagePath = self::CCIMG;
			$cssClass = 'cc';
			$imageUrl = 'http://creativecommons.org/licenses/by-nc-nd/3.0/';
		} else {
			$imagePath = self::NURINFOIMG;
			$cssClass = 'info';
			if ($image['original']['copyright_url']) {
				$imageUrl = $image['original']['copyright_url'];
			}
		}

		$completeImagePath = $licenseImagePath . '/' . $imagePath;
		$bild = array();
		$bild['file'] = $completeImagePath;

		// Configuration for the image link
		if ($imageUrl != '') {
			$bild['imageLinkWrap'] = 1;
			$bild['imageLinkWrap.']['enable'] = 1;
			$bild['imageLinkWrap.']['typolink.']['parameter'] = $imageUrl;
			$bild['imageLinkWrap.']['typolink.']['extTarget'] = '_blank';
			$bild['imageLinkWrap.']['JSWindow.'] = 0;

		}
		// add title to the image
		$bild['titleText'] = $imageTitleText;

		$bild['altText'] = $image['title'];

		$imageInformation = $this->local_cObj->IMAGE($bild);

		// return with a special css class for that particular image
		return '<div class=" bigpicture-license bigpicture-license-' . $cssClass . '">' . $imageInformation . '</div>';

	}

}