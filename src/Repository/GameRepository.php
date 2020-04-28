<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Param;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findAllByCategories(array $categoriesId, $isBorrowed = false)
    {
        $query = $this->createQueryBuilder('g')
            ->join('g.category', 'c')
            ->where('g.isBorrowed = :val')
            ->setParameter('val', $isBorrowed);


        $orQuery = "";
        foreach ($categoriesId as $id) {
            $orQuery .= "g.category = " . $id . " OR ";
        }
        $orQuery = substr($orQuery, 0, strlen($orQuery) - 4);

        $parentCategoryQuery = "";
        foreach ($categoriesId as $id) {
            $parentCategoryQuery .= "c.parentCategory = " . $id . " OR ";
        }
        $parentCategoryQuery = substr($parentCategoryQuery, 0, strlen($parentCategoryQuery) - 4);
        return $query->andWhere($orQuery)
            ->orWhere($parentCategoryQuery)
            ->getQuery()
            ->getResult();
    }
}
