<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Two Click Media',
    'description' => 'Enable external youtube and vimeo videos only on click for TYPO3',
    'category' => 'misc',
    'author' => 'b13 GmbH',
    'author_email' => 'typo3@b13.com',
    'author_company' => 'b13 GmbH',
    'state' => 'stable',
    'uploadfolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-11.99.99',
            'assetcollector' => '*',
        ],
    ],
    'autoload' => [
        'psr-4' =>
            [
                'B13\\Twoclickmedia\\' => 'Classes',
            ],
    ],
];
