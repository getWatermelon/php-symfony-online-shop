<?php


namespace App\Service\Search;


interface SearcherInterface
{
    public function searchByQuery(string $query) : array;
}