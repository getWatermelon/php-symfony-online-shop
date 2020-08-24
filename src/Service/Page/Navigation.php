<?php
declare(strict_types=1);


namespace App\Service\Page;


use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;


/**
 * Class Navigation
 * @package App\Service\Page
 */
class Navigation
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    private $productRepo;

    /**
     * Navigation constructor.
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * @return \App\Entity\Category[]
     */
    public function getMenu()
    {
        return $this->categoryRepo->findBy([
            'parent' => null
        ]);
    }

    public function AllCategories()
    {
        return $this->categoryRepo->findAll();
    }

    public function getTopProducts()
    {
        return $this->productRepo->findBy([
           'isTop' => true
        ]);
    }

    public function getSaleProducts()
    {
        return $this->productRepo->findBy([
            'isOnSale' => true
        ]);
    }
}