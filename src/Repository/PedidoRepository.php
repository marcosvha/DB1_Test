<?php

namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pedido::class);
    }
    
    public function getProximoNumero()
    {
        $iProximoNumero = $this->createQueryBuilder('e')
            ->select('MAX(p.numero)')
            ->from('App\Entity\Pedido', 'p')
            ->getQuery()
            ->getSingleScalarResult();    
        
        return (int)$iProximoNumero + 1;
    }      

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
