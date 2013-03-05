<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingo Pfennigstorf <pfennigstorf@sub.uni-goettingen.de>
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
 * ************************************************************* */
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
	// add PageTS
t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/030_PageTS/setup.txt">');

	// RTE
t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/040_Rte/setup.txt">');

	// add UserTS
t3lib_extMgm::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/020_UserTS/setup.txt">');


	// add Rootlinefield for Pictureinheritance
$rootLineFields = &$GLOBALS["TYPO3_CONF_VARS"]['FE']['addRootLineFields'];
if ($rootLineFields != '') {
	$rootLineFields .= ' , ';
}

$rootLineFields .= 'tx_nkwsubmenu_picture_follow,tx_nkwsubmenu_picture,tx_nkwsubmenu_knotheader';
?>