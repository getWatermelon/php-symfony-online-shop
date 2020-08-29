<?php


namespace App\Service\Search;


/**
 * Interface SearcherInterface
 * @package App\Service\Search
 */
interface SearcherInterface
{
    /**
     * @param string $query
     * @return array
     */
    public function searchByQuery(string $query): array;
}