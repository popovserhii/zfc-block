<?php
namespace Agere\Block;

return [

    'assetic_configuration' => require_once 'assets.global.php',

	'view_helpers' => [
		'aliases' => [
			'block' => View\Helper\BlockHelper::class,
		],
		'factories' => [
            View\Helper\BlockHelper::class => View\Helper\Factory\BlockHelperFactory::class
		],
	],

	'service_manager' => [
		'factories' => [
			'BlockPluginManager' => Service\Plugin\BlockPluginFactory::class,
		],
	],

	'block_plugins' => [
		'aliases' => [
            'AdminItems' => Block\Admin\Items::class,
            'AdminToolbar' => Block\Admin\Toolbar::class,
            'Columns' => Block\Admin\Columns::class,

            'Column' => Block\Admin\Column\Column::class,
            'Sequence' => Block\Admin\Column\Sequence::class,
            'Checkbox' => Block\Admin\Column\Checkbox::class,
        ],
		//'invokables' => [],
        'factories' => [
            Block\Admin\Items::class => Service\Factory\BlockFactory::class,
            Block\Admin\Toolbar::class => Service\Factory\BlockFactory::class,
            Block\Admin\Columns::class => Service\Factory\BlockFactory::class,

            // columns
            Block\Admin\Column\Column::class => Service\Factory\BlockFactory::class,
            Block\Admin\Column\Sequence::class => Service\Factory\BlockFactory::class,
            Block\Admin\Column\Checkbox::class => Service\Factory\BlockFactory::class,
        ],
		'abstract_factories' => [
			Service\Factory\BlockAbstractFactory::class,
		],
		'shared' => [
            Block\Admin\Items::class => false,
            Block\Admin\Toolbar::class => false,
            Block\Admin\Columns::class => false,
            Block\Admin\Column\Column::class => false,
            Block\Admin\Column\Sequence::class => false,
            Block\Admin\Column\Checkbox::class => false,
		]
	],

	'block_plugin_config' => [
		'default' => [
            Block\Admin\Items::class => [
				'template' => 'block/items'
			],
            Block\Admin\Toolbar::class => [
				'template' => 'block/toolbar',
                'accessor' => 'ViewHelperManager::user'
			],
            Block\Admin\Columns::class => [
                'factory' => '::BlockPluginManager'
			],
		],
	],

	'view_manager' => [
		'template_map' => [
            'block/items' => __DIR__ . '/../view/agere/block/items.phtml',
            'block/toolbar' => __DIR__ . '/../view/agere/block/toolbar.phtml',
            'block/buttons' => __DIR__ . '/../view/agere/block/buttons.phtml',
            'block/action-panel' => __DIR__ . '/../view/agere/block/action-panel.phtml',
        ],
		'template_path_stack' => [
			__NAMESPACE__ => __DIR__ . '/../view',
		],
	],
];