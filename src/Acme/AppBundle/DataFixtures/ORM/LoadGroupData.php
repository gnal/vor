<?php

namespace Acme\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Msi\UserBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    protected $dic;

    public function setContainer(ContainerInterface $dic = null)
    {
        $this->dic = $dic;
    }

    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setName('admin');
        $group->setRoles(array(
            'ROLE_ADMIN',
        ));
        $this->addReference('group1', $group);
        $manager->persist($group);
        // FLUSH
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
