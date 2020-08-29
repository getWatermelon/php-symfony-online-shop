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

    /**
     * @var ProductRepository
     */
    private $productRepo;

    /**
     * @var SessionInterface
     */
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

    /**
     * @return \App\Entity\Category[]
     */
    public function AllCategories()
    {
        return $this->categoryRepo->findAll();
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getTopProducts()
    {
        return $this->productRepo->findBy([
            'isTop' => 1
        ]);
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getSaleProducts()
    {
        return $this->productRepo->findBy([
            'isOnSale' => 1
        ]);
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getHistoryProducts()
    {
        return $this->productRepo->findBy([
            'id' => $this->session->get('history')
        ]);
    }
}