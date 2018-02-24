<?php
namespace Popov\ZfcBlock;

use Popov\ZfcBlock\Plugin\BlockPluginManager;
use Popov\ZfcBlock\Factory\BlockPluginManagerFactory;

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

    // Middleware way
	'dependencies' => [
	    'aliases' => [
            'BlockPluginManager' => BlockPluginManager::class,
        ],
		'factories' => [
            BlockPluginManager::class => BlockPluginManagerFactory::class,
        ],
	],

    // MVC way. 'service_manager' config leave only for compatibility with ZF ModuleManager.
    // As BlockPluginManager is created on the top level of project initialization.
	'service_manager' => [
        'aliases' => [
            'BlockPluginManager' => BlockPluginManager::class,
        ],
		'factories' => [
            BlockPluginManager::class => Plugin\BlockPluginFactory::class, // this difference is important
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
            Block\Admin\Items::class => Factory\BlockFactory::class,
            Block\Admin\Toolbar::class => Factory\BlockFactory::class,
            Block\Admin\Columns::class => Factory\BlockFactory::class,

            // columns
            Block\Admin\Column\Column::class => Factory\BlockFactory::class,
            Block\Admin\Column\Sequence::class => Factory\BlockFactory::class,
            Block\Admin\Column\Checkbox::class => Factory\BlockFactory::class,
        ],
		'abstract_factories' => [
			//Factory\BlockAbstractFactory::class,
		],
		'shared' => [
            Block\Admin\Items::class => false,
            Block\Admin\Toolbar::class => false,
            Block\Admin\Columns::class => false,
            Block\Admin\Column\Column::class => false,
            Block\Admin\Column\Sequence::class => false,
            Block\Admin\Column\Checkbox::class => false,
		],
        'initializers' => [
            'BlockPluginInterface' => Factory\BlockInitializer::class,
        ],
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