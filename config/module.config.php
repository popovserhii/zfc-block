<?php
namespace Ageme\Block;

return [

	'assets_bundle' => [
		'production' => false,
		'assets' => [
			'css' => [__DIR__ . '/../view/public/css'],
			//'js' => ['js'],
			'js' => [
				__DIR__ . '/../view/public/js/admin/general.js',
				__DIR__ . '/../view/public/js/admin/actionPanel.js',
			],
			//'media' => ['img', 'fonts']
		]
	],

	'view_helpers' => [
		'invokables' => [
			'block' => 'Ageme\Block\View\Helper\Block',
		],
		'factories' => [
			//'block' => ''
		],
	],

	'service_manager' => [
		'factories' => [
			'BlockPluginManager' => 'Ageme\Block\Service\Plugin\BlockPluginFactory',
		],
	],

	'block_plugins' => [
		//'invokables' => [],
		'abstract_factories' => [
			'Ageme\Block\Service\Factory\BlockFactory',
		],
	],


	'block_plugin_config' => [
		'default' => [
			'block/admin/items' => [
				'template' => 'block/items'
			],
			/*'block/admin/actionPanel' => [
				'template' => 'block/actionPanel'
			],*/
		],
	],


	'view_manager' => [
		'template_map' => [
			'block/items' => __DIR__ . '/../view/ageme/block/items.phtml',
			'block/actionPanel' => __DIR__ . '/../view/ageme/block/actionPanel.phtml',
		],
		'template_path_stack' => [
			__NAMESPACE__ => __DIR__ . '/../view',
		],
	],
];