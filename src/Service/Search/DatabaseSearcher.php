<?php
declare(strict_types=1);


namespace App\Service\Search;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use function Doctrine\ORM\QueryBuilder;

/**
 * Class Searcher
 * @package App\Service\Search
 */
class DatabaseSearcher implements SearcherInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Searcher constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $query
     * @return int|mixed|string
     */
    public function searchByQuery(string $query) : array
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->from(Product::class,'a')
            ->select('a')
            ->where($qb->expr()->like(
                'a.title',
                $qb->expr()->literal("%$query%")
            )
            )
            ->getQuery();
        return $result->getResult();
    }
}