<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produto::class);
    }
    
    public function findByNome($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.nome like :value')->setParameter('value', '%' . $value . '%')
            ->orderBy('p.nome', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByCodigo($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.codigo = :value')->setParameter('value', $value)
            ->orderBy('p.codigo', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
