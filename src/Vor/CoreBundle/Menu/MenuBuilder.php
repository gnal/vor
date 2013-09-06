<?php

namespace Vor\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Msi\AdminBundle\Menu\BaseMenuBuilder;

class MenuBuilder extends BaseMenuBuilder
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $this->getMenu('main');

        $menu->setChildrenAttribute('class', 'menu');

        return $this->execute($menu);
    }
}
