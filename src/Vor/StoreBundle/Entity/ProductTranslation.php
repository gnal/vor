<?php

namespace Vor\StoreBundle\Entity;

use Msi\StoreBundle\Model\ProductTranslation as BaseProductTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ProductTranslation extends BaseProductTranslation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
