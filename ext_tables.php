<?php

if (!defined('TYPO3_MODE'))
	die('Access denied.');

	// Configuration
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/001_Configuration', 'SUB Configuration');

	// Plugins
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins', 'SUB Plugin Configuration');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Solr', 'SUB Solr Configuration');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Tt_Address', 'SUB Address Configuration');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/Linkhandler', 'SUB Linkhandler Configuration');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/010_Plugins/News', 'SUB News Configuration');


	// DAM configuration
$tempColumns = array(
	'copyright_url' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:nkwtcadam/locallang_db.xml:tx_dam.copyright_url',
		'config' => array(
			'type' => 'input',
			'size' => '30',
			'wizards'  => array(
				'_PADDING' => 2,
				'link'     => array(
					'type'         => 'popup',
					'title'        => 'Link',
					'icon'         => 'link_popup.gif',
					'script'       => 'browse_links.php?mode=wizard',
					'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
				)
			)
        )
    ),
	'title' => array(
		'exclude' => '1',
		'l10n_mode' => '',
		'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.title',
		'config' => array(
			'type' => 'text',
			'rows' => '6',
			'cols' => '30',
			'eval' => 'required',
		)
	),
	'wiki_commons' => array(
		'exclude' => '1',
		'l10n_mode' => '',
		'label' => 'LLL:EXT:nkwtcadam/locallang_db.xml:tx_dam.wiki_commons',
		'config' => array(
			'type' => 'text',
			'rows' => '6',
			'cols' => '30',
		)
	),
	'cc' => array (
		'exclude' => '1',
		'l10n_mode' => '',
		'label' => 'LLL:EXT:nkwtcadam/locallang_db.xml:tx_dam.cc',
		'config' => array(
			'type' => 'check',
		)
	)
);

	// TCA von DAM laden
t3lib_div::loadTCA('tx_dam');

	// Felder aendern / hinzufuegen
t3lib_extMgm::addTCAcolumns('tx_dam',$tempColumns,1);

	// Copyright Url hinter das Copyrightfeld
t3lib_extMgm::addToAllTCAtypes('tx_dam', 'copyright_url', '', 'after:copyright');

	// Copyright Url hinter das Copyrightfeld
t3lib_extMgm::addToAllTCAtypes('tx_dam', 'wiki_commons', '', 'after:copyright_url');

	// CC Lizenz
t3lib_extMgm::addToAllTCAtypes('tx_dam', 'cc', '', 'after:wiki_commons');

$TCA['tx_dam']['columns']['title']['config']['eval'] = 'required';
$TCA['tx_dam']['columns']['caption']['config']['eval'] = 'required';
$TCA['tx_dam']['columns']['alt_text']['config']['eval'] = 'required';
$TCA['tx_dam']['columns']['exturl']['config']['eval'] = 'required';

    // add fields to index preset fields
$TCA['tx_dam']['txdamInterface']['copyright_fieldList'] .= ',copyright_url';

?>