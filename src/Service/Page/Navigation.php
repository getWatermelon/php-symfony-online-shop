<?php
declare(strict_types=1);


namespace App\Service\Page;


use App\Repository\CategoryRepository;


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

    /**
     * Navigation constructor.
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
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
}