<?php

namespace App\Repository;

use App\Entity\Typespace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typespace|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typespace|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typespace[]    findAll()
 * @method Typespace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypespaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typespace::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('t');
    }
    
    /**
     * @param string $typeespace
     * @return Typespace|null
     */
    public function findByTypeespace(string $typeespace): ?Typespace
    {
        return $this->findOneBy(['typeespace' => $typeespace]);
    }
    public function findAllTypespace()
    {
        return $this->createQueryBuilder('t')
            ->select('t.typeespace')
            ->orderBy('t.typeespace', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
