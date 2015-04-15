<?php
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_realurl_pathsegment';
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
		'fixedPostVars' => array(
				'newsDetailConfiguration' => array(
						array(
								'GETvar' => 'tx_news_pi1[news]',
								'lookUpTable' => array(
										'table' => 'tx_news_domain_model_news',
										'id_field' => 'uid',
										'alias_field' => 'title',
										'addWhereClause' => ' AND NOT deleted',
										'useUniqueCache' => 1,
										'useUniqueCache_conf' => array(
												'strtolower' => 1,
												'spaceCharacter' => '-'
										),
										'languageGetVar' => 'L',
										'languageExceptionUids' => '',
										'languageField' => 'sys_language_uid',
										'transOrigPointerField' => 'l10n_parent',
										'autoUpdate' => 1,
										'expireDays' => 180,
								)
						)
				),
				'newsCategoryConfiguration' => array(
						array(
								'GETvar' => 'tx_news_pi1[overwriteDemand][categories]',
								'lookUpTable' => array(
										'table' => 'sys_category',
										'id_field' => 'uid',
										'alias_field' => 'title',
										'addWhereClause' => ' AND NOT deleted',
										'useUniqueCache' => 1,
										'useUniqueCache_conf' => array(
												'strtolower' => 1,
												'spaceCharacter' => '-'
										)
								)
						)
				),
				'newsTagConfiguration' => array(
						array(
								'GETvar' => 'tx_news_pi1[overwriteDemand][tags]',
								'lookUpTable' => array(
										'table' => 'tx_news_domain_model_tag',
										'id_field' => 'uid',
										'alias_field' => 'title',
										'addWhereClause' => ' AND NOT deleted',
										'useUniqueCache' => 1,
										'useUniqueCache_conf' => array(
												'strtolower' => 1,
												'spaceCharacter' => '-'
										)
								)
						)
				),
			// uid of the target page. For additional detail/category/tag pages, add their uid as well
				'2439' => 'newsDetailConfiguration', // Einzelansicht Aktuelles
				'2443' => 'newsDetailConfiguration', // Archiv
				'2444' => 'newsDetailConfiguration', // Einzelansicht Archiv
				'2441' => 'newsDetailConfiguration', // Einzelansicht Stellenangebot
				'2440' => 'newsCategoryConfiguration', // Liste nach Kategorie
				'194' => 'newsCategoryConfiguration', // Liste Stellenangebote
		),
		'postVarSets' => array(
				'_DEFAULT' => array(
						'controller' => array(
								array(
										'GETvar' => 'tx_news_pi1[action]',
										'noMatch' => 'bypass'
								),
								array(
										'GETvar' => 'tx_news_pi1[controller]',
										'noMatch' => 'bypass'
								)
						),
						'dateFilter' => array(
								array(
										'GETvar' => 'tx_news_pi1[overwriteDemand][year]',
								),
								array(
										'GETvar' => 'tx_news_pi1[overwriteDemand][month]',
								),
						),
						'page' => array(
								array(
										'GETvar' => 'tx_news_pi1[@widget_0][currentPage]',
								),
						),
						'tags' => array(
								array(
										'GETvar' => 'tx_nkwkeywords_detail[category]',
										'lookUpTable' => array(
												'table' => 'sys_category',
												'id_field' => 'uid',
												'alias_field' => 'title',
												'useUniqueCache' => 1,
												'useUniqueCache_conf' => array(
														'strtolower' => 1,
														'spaceCharacter' => '-',
												),
												'languageGetVar' => 'L',
												'languageExceptionUids' => '',
												'languageField' => 'sys_language_uid',
												'transOrigPointerField' => 'l10n_parent',
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
				),
		),
		'fileName' => array(
				'defaultToHTMLsuffixOnPrev' => FALSE,
				'index' => array(
						'sub.rss' => array(
								'keyValues' => array(
										'type' => 1345790301,
								),
						),
				),
		),
);
?>
