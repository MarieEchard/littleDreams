<?php

namespace App\Repository;

use App\Entity\ItemPortfolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<ItemPortfolio>
 *
 * @method ItemPortfolio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemPortfolio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemPortfolio[]    findAll()
 * @method ItemPortfolio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemPortfolioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemPortfolio::class);
    }

}
