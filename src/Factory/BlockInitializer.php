<?php
/**
 * Block initializer
 *
 * @category Popov
 * @package Popov_ZfcBlock
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 06.04.2016 22:57
 */
namespace Popov\ZfcBlock\Factory;

use Popov\ZfcBlock\Factory\BlockFactoryTrait;
//use Psr\Container\ContainerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Popov\ZfcBlock\Plugin\BlockPluginInterface;

class BlockInitializer
{
    use BlockFactoryTrait;

    public function __invoke(ContainerInterface $container, $instance)
    {
        if (get_class($container) !== ServiceManager::class) {
            $container = $container->getServiceLocator();
        }

        if ($instance instanceof BlockPluginInterface) {
            //$instance->setObjectManager($container->get('Doctrine\ORM\EntityManager'));
            $this->init($container, $instance);
        }
    }
}