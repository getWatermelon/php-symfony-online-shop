<?php
declare(strict_types=1);


namespace App\Service\Page;


use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


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

    private $session;

    /**
     * Navigation constructor.
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepo, SessionInterface $session)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->session = $session;
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

    public function getHistoryProducts()
    {
//        if ($this->session->has('history')) {
            return $this->productRepo->findBy([
                'id' => $this->session->get('history')
            ]);
//        }
    }
}