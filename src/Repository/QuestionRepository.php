<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function trouverQuestionsEnAttenteParEmail(string $email): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.email = :email')
            ->andWhere('q.status = :status')
            ->setParameter('email', $email)
            ->setParameter('status', Question::STATUS_EN_ATTENTE)
            ->getQuery()
            ->getResult();
    }
}
