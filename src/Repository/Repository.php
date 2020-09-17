<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class Repository extends EntityRepository
{

    /**
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function paginate(int $page = 1, int $limit = 20): Paginator
    {
        $query = $this
            ->createQueryBuilder('q')
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit)
        ;

        return $paginator;
    }

}
