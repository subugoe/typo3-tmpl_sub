<?php

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
	'init' => array(
		'enableCHashCache' => 1,
		'appendMissingSlash' => 'ifNotFile,redirect',
		'enableUrlDecodeCache' => 0,
		'enableUrlEncodeCache' => 0,
		'adminJumpToBackend' => 1,
		'emptyUrlReturnValue' => '/',
		'postVarSet_failureMode' => 'redirect_goodUpperDir',
	),
	'pagePath' => array(
		'type' => 'user',
		'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
		'spaceCharacter' => '-',
		'languageGetVar' => 'L',
		'expireDays' => 7,
		'rootpage_id' => 3,
		'dontResolveShortcuts' => 1
	),
	'preVars' => array(
		array(
			'GETvar' => 'L',
			'valueMap' => array(
				'en' => '1',
			),
			'valueDefault' => 'de',
			'noMatch' => 'bypass',
		),
		array(
			'GETvar' => 'no_cache',
			'valueMap' => array(
				'nc' => 1,
			),
			'noMatch' => 'bypass',
		),
	),
	'postVarSets' => array(
		'_DEFAULT' => array(
			'tags' => array(
				array(
					'GETvar' => 'tx_nkwkeywords_keyword[keyword]',
					'lookUpTable' => array(
						'table' => 'tx_nkwkeywords_domain_model_keywords',
						'id_field' => 'uid',
						'alias_field' => 'title',
							//'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				)
			),
				// schulungen
			'schulung' => array(
				array(
					'GETvar' => 'tx_schulungen_schulungen[schulung]',
					'lookUpTable' => array(
						'table' => 'tx_schulungen_domain_model_schulung',
						'id_field' => 'uid',
						'alias_field' => 'titel',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				)
			),
			'termin' => array(
				array(
					'GETvar' => 'tx_schulungen_schulungen[termin]',
				),
			),
			's' => array(
				array(
					'GETvar' => 'tx_schulungen_schulungen[controller]',
				),
				array(
					'GETvar' => 'tx_schulungen_schulungen[action]'
				)
			),
				// substaff
			'person' => array(
				array(
					'GETvar' => 'tx_substaff_persondetails[person]',
					'lookUpTable' => array(
						'table' => 'tt_address',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'abteilunggruppe' => array(
				array(
					'GETvar' => 'tx_substaff_groupdetails[group]',
					'lookUpTable' => array(
						'table' => 'tt_address_group',
						'id_field' => 'uid',
						'alias_field' => 'title',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'institution' => array(
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi6[action]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi6[controller]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi6[institution]',
					'lookUpTable' => array(
						'table' => 'tx_nkwsubfeprojects_domain_model_institution',
						'id_field' => 'uid',
						'alias_field' => 'title',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'schlagwort' => array(
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi4[action]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi4[controller]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi4[keyword]',
					'lookUpTable' => array(
						'table' => 'tx_nkwsubfeprojects_domain_model_keywords',
						'id_field' => 'uid',
						'alias_field' => 'title',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'buch' => array(
				array(
					'GETvar' => 'tx_patenschaften_pi1[showBook]',
					'lookUpTable' => array(
						'table' => 'tx_patenschaften_buecher',
						'id_field' => 'uid',
						'alias_field' => 'titel',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'buchkategorie' => array(
				array(
					'GETvar' => 'tx_patenschaften_pi1[category]',
					'lookUpTable' => array(
						'table' => 'tx_patenschaften_kategorien',
						'id_field' => 'uid',
						'alias_field' => 'catname',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
				// projekt
			'projekt' => array(
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi2[action]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi2[controller]',
					'noMatch' => 'bypass',
				),
				array(
					'GETvar' => 'tx_nkwsubfeprojects_pi2[project]',
					'lookUpTable' => array(
						'table' => 'tx_nkwsubfeprojects_domain_model_project',
						'id_field' => 'uid',
						'alias_field' => 'title',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),

				),
			),
			'bibliothek' => array(
				array(
					'GETvar' => 'tx_standorte_pi1[bibliothek]',
					'lookUpTable' => array(
						'table' => 'tx_standorte_domain_model_bibliothek',
						'id_field' => 'uid',
						'alias_field' => 'titel',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'fakultaet' => array(
				array(
					'GETvar' => 'tx_standorte_pi1[fakultaet]',
					'lookUpTable' => array(
						'table' => 'tx_standorte_domain_model_fakultaet',
						'id_field' => 'uid',
						'alias_field' => 'titel',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
			),
			'a' => array(
				array(
					'GETvar' => 'tx_standorte_pi1[action]',
				),
				array(
					'GETvar' => 'tx_standorte_pi1[controller]',
				)
			),
				// news archive parameters
			'archive' => array(
				array(
					'GETvar' => 'tx_ttnews[year]',
				),
				array(
					'GETvar' => 'tx_ttnews[month]',
					'valueMap' => array(
						'january' => '01',
						'february' => '02',
						'march' => '03',
						'april' => '04',
						'may' => '05',
						'june' => '06',
						'july' => '07',
						'august' => '08',
						'september' => '09',
						'october' => '10',
						'november' => '11',
						'december' => '12',
					)
				),
			),
				// news pagebrowser
			'browse' => array(
				array(
					'GETvar' => 'tx_ttnews[pointer]',
				),
			),
				// news categories
			'select_category' => array(
				array(
					'GETvar' => 'tx_ttnews[cat]',
				),
			),
				// news articles and searchwords
			'article' => array(
				array(
					'GETvar' => 'tx_ttnews[tt_news]',
					'lookUpTable' => array(
						'table' => 'tt_news',
						'id_field' => 'uid',
						'alias_field' => 'title',
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						),
					),
				),
				array(
					'GETvar' => 'tx_ttnews[swords]',
				),
			),
		),
	),
	'fileName' => array(
		'defaultToHTMLsuffixOnPrev' => FALSE,
		'index' => array(
			'rss.xml' => array(
				'keyValues' => array(
					'type' => 1345790301,
				),
			),
		),
	),
);
?>