<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PedidoCabeceraRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoCabeceraRepository extends EntityRepository
{

    public function getPedidos()
    {

        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.activo = true')
            ->andWhere('(TIMESTAMPDIFF(HOUR, p.fechaCreacion,  :hoy)) <= :hora')
            ->setParameter('hoy', new \DateTime())
            ->setParameter('hora', 10000);

        $sql = $qb->getQuery()->getSQL();

        return $qb->getQuery()->getArrayResult();
    }
}
