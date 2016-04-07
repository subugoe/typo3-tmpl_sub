<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Configuration
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/001_Configuration', 'SUB Configuration');

// Plugins
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins', 'SUB Plugin Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Solr', 'SUB Solr Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Tt_Address', 'SUB Address Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Linkhandler', 'SUB Linkhandler Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/News', 'SUB News Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/WecMap', 'SUB Map Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Powermail', 'SUB Powermail Configuration');

$tempColumns = [
        'copyright' => [
                'exclude' => '1',
                'l10n_mode' => '',
                'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.copyright',
                'config' => [
                        'type' => 'input',
                        'size' => '30',
                ]
        ],
        'copyright_url' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.copyright_url',
                'config' => [
                        'type' => 'input',
                        'size' => '30',
                        'wizards' => [
                                '_PADDING' => 2,
                                'link' => [
                                        'type' => 'popup',
                                        'title' => 'Link',
                                        'icon' => 'link_popup.gif',
                                        'script' => 'browse_links.php?mode=wizard',
                                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                                ]
                        ]
                ]
        ],
        'wiki_commons' => [
                'exclude' => '1',
                'l10n_mode' => '',
                'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.wiki_commons',
                'config' => [
                        'type' => 'text',
                        'rows' => '6',
                        'cols' => '30',
                ]
        ],
        'creative_commons' => [
                'exclude' => '1',
                'l10n_mode' => '',
                'label' => 'LLL:EXT:tmpl_sub/Resources/Private/Language/locallang.xml:sys_file_metadata.creative_commons',
                'config' => [
                        'type' => 'check',
                ]
        ]
];

// Add fields to sys_file_metadata
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_metadata', $tempColumns);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'copyright', '', 'after:download_name');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'copyright_url', '', 'after:copyright');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'wiki_commons', '', 'after:copyright_url');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'creative_commons', '', 'after:wiki_commons');

$TCA['sys_file_metadata']['columns']['alt_text']['config']['eval'] = 'required';
$TCA['sys_file_metadata']['columns']['exturl']['config']['eval'] = 'required';
$TCA['sys_file_metadata']['columns']['copyright']['config']['eval'] = 'required';

/**
 * Register Custom Fluid Content Element
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'Social Infobox',
        'tmplsub_socialinfobox'
    ],
    'CType'
);
/**
 * Prepare TCA for Custom Fluid Content Element
 */
$TCA['tt_content']['types']['tmplsub_socialinfobox']['showitem'] = $TCA['tt_content']['types']['bullets']['showitem'];

/**
 * Register Lecture Content Element
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'Lectures',
        'tmplsub_lectures'
    ],
    'CType'
);
/**
 * Prepare TCA for Custom Fluid Content Element
 */
$TCA['tt_content']['types']['tmplsub_lectures'] = $TCA['tt_content']['types']['table'];
$TCA['tt_content']['columns']['pi_flexform']['config']['ds']['*,tmplsub_lectures'] = 'FILE:EXT:css_styled_content/flexform_ds.xml';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'Lectures',
        'tmplsub_lectures',
        'content-image'
    ],
    'textmedia',
    'after'
);

// mandatory fields for the backend
$TCA['be_users']['columns']['email']['config']['eval'] = 'trim,required';
$TCA['be_users']['columns']['realName']['config']['eval'] = 'trim,required';
$TCA['be_groups']['columns']['description']['config']['eval'] = 'required';
$TCA['be_groups']['columns']['lockToDomain']['config']['disabled'] = true;
$TCA['tt_content']['columns']['header']['config']['eval'] = 'trim,required';
$TCA['tt_content']['columns']['altText']['config']['eval'] = 'trim,required';
$TCA['tt_content']['columns']['titleText']['config']['eval'] = 'trim,required';
$TCA['tt_content']['columns']['imagecaption']['config']['type'] = "input";
$TCA['tt_content']['columns']['imagecaption']['config']['eval'] = "trim,required";
$TCA['tt_content']['columns']['imagecaption']['config']['max'] = 256;
$TCA['pages']['columns']['categories']['config']['minitems'] = 1;
$TCA['pages']['columns']['categories']['config']['foreign_table_where'] = ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC';
$TCA['pages']['columns']['description']['config']['eval'] = 'required';
$TCA['pages_language_overlay']['columns']['description']['config']['eval'] = 'required';
$TCA['pages_language_overlay']['columns']['description']['config']['type'] = 'text';
$TCA['pages_language_overlay']['columns']['description']['config']['cols'] = 40;
$TCA['pages_language_overlay']['columns']['description']['config']['rows'] = 3;
$TCA['pages_language_overlay']['columns']['categories']['config']['minitems'] = 1;
