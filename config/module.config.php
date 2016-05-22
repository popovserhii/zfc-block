<?php
namespace Agere\Block;

return [

	'assets_bundle' => [
		'production' => false,
		'assets' => [
			'css' => ['media/css/theme.css', /*__DIR__ . '/../view/public/css'*/],
			//'less' => ['media/less/theme.less'], // @todo wait fix bug @link https://github.com/neilime/zf2-assets-bundle/issues/37
			//'js' => ['js'],
			'js' => [
				//__DIR__ . '/../view/public/js/admin/general.js', //@todo Add files per template, all by once is not good

				'@zfRootPath/vendor/twbs/bootstrap/js/button.js',
				'@zfRootPath/vendor/twbs/bootstrap/js/dropdown.js',
				'@zfRootPath/vendor/twbs/bootstrap/js/modal.js',

				__DIR__ . '/../view/public/js/admin/action-panel.js',
			],
			//'media' => ['img', 'fonts']
		]
	],

	'view_helpers' => [
		'invokables' => [
			'block' => 'Agere\Block\View\Helper\Block',
		],
		'factories' => [
			//'block' => ''
		],
	],

	'service_manager' => [
		'factories' => [
			'BlockPluginManager' => 'Agere\Block\Service\Plugin\BlockPluginFactory',
		],
	],

	'block_plugins' => [
		//'invokables' => [],
		'abstract_factories' => [
			'Agere\Block\Service\Factory\BlockFactory',
		],
		'shared' => [
			'block/admin/toolbar' => false,
		]
	],


	'block_plugin_config' => [
		'default' => [
			'block/admin/items' => [
				'template' => 'block/items'
			],
			'block/admin/toolbar' => [
				'template' => 'block/toolbar'
			],
			/*'block/admin/actionPanel' => [
				'template' => 'block/action-panel'
			],*/
		],
	],


	'view_manager' => [
		'template_map' => [
			'block/items' => __DIR__ . '/../view/agere/block/items.phtml',
			'block/action-panel' => __DIR__ . '/../view/agere/block/action-panel.phtml',
			'block/toolbar' => __DIR__ . '/../view/agere/block/toolbar.phtml',
			'block/buttons' => __DIR__ . '/../view/agere/block/buttons.phtml',
		],
		'template_path_stack' => [
			__NAMESPACE__ => __DIR__ . '/../view',
		],
	],
];