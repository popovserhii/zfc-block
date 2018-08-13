# ZF Block Helper
Create separately custom template bock with html, css, js etc.

## Usage
**For Expressive**: register `ZfcBlock` module in `config/config.php` with `Popov\ZfcBlock\ConfigProvider::class`.

**For MVC**: register with `Popov\ZfcBlock` in your configuration.


Create new `Block` class in your module with name `LoginBlock`
```php
// src/Your/Module/src/Block/LoginBlock.php

namespace Stagem\Visitor\Block;

use Popov\ZfcBlock\Block\Core;
use Popov\ZfcUser\Form\LoginForm;

class LoginBlock extends Core
{
    /**
     * @var LoginForm
     */
    protected $loginForm;

    public function __construct(LoginForm $loginForm)
    {
        $this->loginForm = $loginForm;
    }

    public function getLoginForm()
    {
        return $this->loginForm;
    }
}
```

This class must extend `Popov\ZfcBlock\Block\Core` for allow usage basic functionality such as translate, check permission
and other auxiliary opportunities.

Next step you can:
* create `Factory` for this block;
* use `ReflectionFactory`, this will be convenient if project is under development. Register factory in your `config/autoload/dependencies.global.php`
    ```php
    return [
        // ...
        'block_plugins' => [
            'abstract_factories' => [
                Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
            ],
        ]
    ];
    ```

If you decide use `ReflectionFactory` then minimum bare you need add alias for your block to configuration
```php
// src/Stagem/Visitor/config/module.config.php
return [
    // ...
    'block_plugins' => [
        'aliases' => [
            'VisitorLogin' => \Your\Module\Block\LoginBlock::class,
        ],
    ],
    'block_plugin_config' => [
        'default' => [
            \Your\Module\Block\LoginBlock::class => [
                'template' => 'visitor::login'
            ],
        ],
    ],
];
```

> Be aware. Don't use `ReflactionFactory` on production, create real `Factory` for your block class.

After that your can call your block in any template with
```php
<div>    
    <?= $this->block()->render('VisitorLogin') ?>
</div>
```

Or the same example with advanced usage
```php
<div> 
    <?php $loginBlock = $this->block('VisitorLogin'); ?>   
    <?= $this->block()->render($loginBlock) ?>
</div>      
```
*Advanced usage* can be useful for set additional parameters.

For example, block template can have next view
```php
// src/Your/Module/view/visitor/login.phtml
<?php
$form = $block->getLoginForm();
$form->setAttribute('action', $this->url('default', [
    'controller' => 'visitor',
    'action' => 'login',
]));
$form->prepare();
?>
<?= $this->form()->openTag($form) ?>
    <div class="modal-content">
        <div class="right-side">
			<div class="form-group">
				<label for="user"><?= $form->get('email')->getLabel() ?>:</label>
				<?= $this->formElement($form->get('email')) ?>
			</div>
			<div class="form-group">
				<label for="password"><?= $form->get('password')->getLabel() ?>:</label>
				<?= $this->formRow($form->get('password')) ?>
			</div>
        </div>
    </div>
<?= $this->form()->closeTag() ?>
```

## Configuration
`block_plugin_config` in config file is used for set some specific configuration for `Block`.
All config parameters will be set with `setter`.

* `default` key sets general configuration for `Block`
* also configuration can be set per `resource/action`, where *resource* in most cases is `controller` or `module` taken from URL.
```php
return [
    // ...
    'block_plugins' => [
        'aliases' => [
            'VisitorLogin' => \Your\Module\Block\LoginBlock::class,
        ],
    ],
    'block_plugin_config' => [
        'visitor/login' => [
            \Your\Module\Block\LoginBlock::class => [
                'template' => 'visitor::login'
            ],
        ],
    ],
];
```
      
If you need some complex parameters in your `Block` use `Factory` for this purpose.
 
## Types
* list (roster)

In action:
```php
public function process(\Psr\Http\Message\ServerRequestInterface $request)
{
	$viewModel = (new ViewModel())->setTemplate('block::list')
		->addChild($viewModelOne, 'one')
		->addChild($viewModelTwo, 'two')
		->addChild($viewModelThree, 'three');

	return $viewModel;
}
```
All your blocks will be rendered automatically one by one.

