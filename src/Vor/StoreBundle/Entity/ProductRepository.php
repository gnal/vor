<?php

namespace Vor\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function getSearchQueryBuilder($searchQuery)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb;
    }
}
