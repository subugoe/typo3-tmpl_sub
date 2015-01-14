<?php

if (!defined('TYPO3_MODE'))
	die('Access denied.');

// Configuration
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/001_Configuration', 'SUB Configuration');

// Plugins
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins', 'SUB Plugin Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Solr', 'SUB Solr Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Tt_Address', 'SUB Address Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Linkhandler', 'SUB Linkhandler Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/News', 'SUB News Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/WecMap', 'SUB Map Configuration');

$tempColumns = array(
		'copyright' => array(
				'exclude' => '1',
				'l10n_mode' => '',
				'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.copyright',
				'config' => array(
						'type' => 'input',
						'size' => '30',
				)
		),
		'copyright_url' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.copyright_url',
				'config' => array(
						'type' => 'input',
						'size' => '30',
						'wizards' => array(
								'_PADDING' => 2,
								'link' => array(
										'type' => 'popup',
										'title' => 'Link',
										'icon' => 'link_popup.gif',
										'script' => 'browse_links.php?mode=wizard',
										'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
								)
						)
				)
		),
		'wiki_commons' => array(
				'exclude' => '1',
				'l10n_mode' => '',
				'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.wiki_commons',
				'config' => array(
						'type' => 'text',
						'rows' => '6',
						'cols' => '30',
				)
		),
		'creative_commons' => array(
				'exclude' => '1',
				'l10n_mode' => '',
				'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.creative_commons',
				'config' => array(
						'type' => 'check',
				)
		)
);

// Add fields to sys_file_metadata
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_metadata', $tempColumns, 1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'copyright', '', 'after:download_name');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'copyright_url', '', 'after:copyright');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'wiki_commons', '', 'after:copyright_url');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'creative_commons', '', 'after:wiki_commons');

$TCA['sys_file_metadata']['columns']['caption']['config']['eval'] = 'required';
$TCA['sys_file_metadata']['columns']['alt_text']['config']['eval'] = 'required';
$TCA['sys_file_metadata']['columns']['exturl']['config']['eval'] = 'required';

?>
