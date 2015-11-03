<?php
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_realurl_pathsegment';
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = [
    'init' => [
        'enableCHashCache' => 1,
        'appendMissingSlash' => 'ifNotFile,redirect',
        'enableUrlDecodeCache' => 0,
        'enableUrlEncodeCache' => 0,
        'adminJumpToBackend' => 1,
        'emptyUrlReturnValue' => '/',
        'postVarSet_failureMode' => 'redirect_goodUpperDir',
    ],
    'pagePath' => [
        'type' => 'user',
        'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
        'spaceCharacter' => '-',
        'languageGetVar' => 'L',
        'expireDays' => 7,
        'rootpage_id' => 3,
        'dontResolveShortcuts' => 1
    ],
    'preVars' => [
        [
            'GETvar' => 'L',
            'valueMap' => [
                'en' => '1',
            ],
            'valueDefault' => 'de',
            'noMatch' => 'bypass',
        ],
        [
            'GETvar' => 'no_cache',
            'valueMap' => [
                'nc' => 1,
            ],
            'noMatch' => 'bypass',
        ],
    ],
    'fixedPostVars' => [
        'newsDetailConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[news]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_news',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => [
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    ],
                    'languageGetVar' => 'L',
                    'languageExceptionUids' => '',
                    'languageField' => 'sys_language_uid',
                    'transOrigPointerField' => 'l10n_parent',
                    'autoUpdate' => 1,
                    'expireDays' => 180,
                ]
            ]
        ],
        'newsCategoryConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[overwriteDemand][categories]',
                'lookUpTable' => [
                    'table' => 'sys_category',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => [
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    ]
                ]
            ]
        ],
        'newsTagConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[overwriteDemand][tags]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_tag',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => [
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    ]
                ]
            ]
        ],
        '2447' => 'newsDetailConfiguration', // Einzelansicht Aktuelles
        '2449' => 'newsDetailConfiguration', // Archiv
        '2450' => 'newsDetailConfiguration', // Einzelansicht Archiv
        '2451' => 'newsDetailConfiguration', // Einzelansicht Stellenangebot
        '2452' => 'newsDetailConfiguration', // Einzelansicht Veranstaltungen
        '2453' => 'newsDetailConfiguration', // Einzelansicht Archiv Veranstaltungen
        '2454' => 'newsDetailConfiguration', // Archiv Veranstaltungen
        '2448' => 'newsCategoryConfiguration', // Liste nach Kategorie
        '194' => 'newsCategoryConfiguration', // Liste Stellenangebote
        '239' => 'newsCategoryConfiguration', // Liste Veranstaltungen
    ],
    'postVarSets' => [
        '_DEFAULT' => [
            'controller' => [
                [
                    'GETvar' => 'tx_news_pi1[action]',
                    'noMatch' => 'bypass'
                ],
                [
                    'GETvar' => 'tx_news_pi1[controller]',
                    'noMatch' => 'bypass'
                ]
            ],
            'dateFilter' => [
                [
                    'GETvar' => 'tx_news_pi1[overwriteDemand][year]',
                ],
                [
                    'GETvar' => 'tx_news_pi1[overwriteDemand][month]',
                ],
            ],
            'page' => [
                [
                    'GETvar' => 'tx_news_pi1[@widget_0][currentPage]',
                ],
            ],
            'tags' => [
                [
                    'GETvar' => 'tx_nkwkeywords_detail[category]',
                    'lookUpTable' => [
                        'table' => 'sys_category',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                    ],
                ]
            ],
            // schulungen
            'schulung' => [
                [
                    'GETvar' => 'tx_schulungen_schulungen[schulung]',
                    'lookUpTable' => [
                        'table' => 'tx_schulungen_domain_model_schulung',
                        'id_field' => 'uid',
                        'alias_field' => 'titel',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ]
            ],
            'termin' => [
                [
                    'GETvar' => 'tx_schulungen_schulungen[termin]',
                ],
            ],
            's' => [
                [
                    'GETvar' => 'tx_schulungen_schulungen[controller]',
                ],
                [
                    'GETvar' => 'tx_schulungen_schulungen[action]'
                ]
            ],
            // substaff
            'person' => [
                [
                    'GETvar' => 'tx_substaff_persondetails[person]',
                    'lookUpTable' => [
                        'table' => 'tt_address',
                        'id_field' => 'uid',
                        'alias_field' => 'name',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'abteilunggruppe' => [
                [
                    'GETvar' => 'tx_substaff_groupdetails[group]',
                    'lookUpTable' => [
                        'table' => 'tt_address_group',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'institution' => [
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi6[action]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi6[controller]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi6[institution]',
                    'lookUpTable' => [
                        'table' => 'tx_nkwsubfeprojects_domain_model_institution',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'schlagwort' => [
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi4[action]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi4[controller]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi4[keyword]',
                    'lookUpTable' => [
                        'table' => 'tx_nkwsubfeprojects_domain_model_keywords',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'buch' => [
                [
                    'GETvar' => 'tx_patenschaften_pi1[showBook]',
                    'lookUpTable' => [
                        'table' => 'tx_patenschaften_buecher',
                        'id_field' => 'uid',
                        'alias_field' => 'titel',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'buchkategorie' => [
                [
                    'GETvar' => 'tx_patenschaften_pi1[category]',
                    'lookUpTable' => [
                        'table' => 'tx_patenschaften_kategorien',
                        'id_field' => 'uid',
                        'alias_field' => 'catname',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            // projekt
            'projekt' => [
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi2[action]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi2[controller]',
                    'noMatch' => 'bypass',
                ],
                [
                    'GETvar' => 'tx_nkwsubfeprojects_pi2[project]',
                    'lookUpTable' => [
                        'table' => 'tx_nkwsubfeprojects_domain_model_project',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'bibliothek' => [
                [
                    'GETvar' => 'tx_standorte_pi1[bibliothek]',
                    'lookUpTable' => [
                        'table' => 'tx_standorte_domain_model_bibliothek',
                        'id_field' => 'uid',
                        'alias_field' => 'titel',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'fakultaet' => [
                [
                    'GETvar' => 'tx_standorte_pi1[fakultaet]',
                    'lookUpTable' => [
                        'table' => 'tx_standorte_domain_model_fakultaet',
                        'id_field' => 'uid',
                        'alias_field' => 'titel',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
            'a' => [
                [
                    'GETvar' => 'tx_standorte_pi1[action]',
                ],
                [
                    'GETvar' => 'tx_standorte_pi1[controller]',
                ]
            ],
        ],
    ],
    'fileName' => [
        'defaultToHTMLsuffixOnPrev' => FALSE,
        'index' => [
            'sub.rss' => [
                'keyValues' => [
                    'type' => 1345790301,
                ],
            ],
        ],
    ],
];
?>
