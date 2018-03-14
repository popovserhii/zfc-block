<?php
namespace Popov\ZfcBlock;

return [
    'default' => [
        'assets' => [
            '@block_css',
            '@block_js',
        ],
        /*'options' => [
            'mixin' => true,
        ],*/
    ],

    'modules' => [
        __NAMESPACE__ => [
            'root_path' => __DIR__ . '/../view/assets',
            'collections' => [
                'block_css' => [
                    'assets' => [
                        //'css/test.css',
                    ],
                    'filters' => [
                        'CssRewriteFilter' => [
                            'name' => 'Assetic\Filter\CssRewriteFilter',
                        ],
                    ],
                ],
                'block_js' => [
                    'assets' => [
                        'js/admin/action-panel.js',
                    ],
                ],
                /*'base_images' => array(
                    'assets' => array(
                        'images/*.png',
                        'images/*.ico',
                    ),
                    'options' => array(
                        'move_raw' => true,
                    )
                ),*/
            ],
        ],
    ],
];
