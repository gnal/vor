<?php

namespace Vor\StoreBundle\Entity;

use Msi\StoreBundle\Model\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Vor\StoreBundle\Entity\ProductRepository")
 */
class Product extends BaseProduct
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
