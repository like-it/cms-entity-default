<?php
namespace Repository;

use Host\Backend\Universeorange\Com\User\Entity\Logger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Logger|null                    find($id, $lockMode = null, $lockVersion = null)
 * @method Logger|null                    findOneBy(array $criteria, array $orderBy = null)
 * @method Logger[]                       findAll()
 * @method Logger[]                       findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoggerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logger::class);
    }

}