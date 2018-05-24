<?php
namespace Popov\ZfcBlock;

return [
    'default' => [
        'assets' => [
            '@block_js',
        ],
    ],

    'modules' => [
        __NAMESPACE__ => [
            'root_path' => __DIR__ . '/../view/assets',
            'collections' => [
                'block_js' => [
                    'assets' => [
                        'js/admin/action-panel.js',
                    ],
                ],
            ],
        ],
    ],
];
