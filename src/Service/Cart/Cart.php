<?php
declare(strict_types=1);


namespace App\Service\Cart;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart implements \Countable
{

    private $repository;

    private $session;

    private $em;

    public function __construct(ProductRepository $repository, SessionInterface $session, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->em = $em;
    }

    public function getItems()
    {
        if ($this->session->has('order')) {
            $products = $this->getProductsList();
            foreach ($products as $product) {
                yield new Item($product, (int) $this->session->get('order')[$product->getId()]);
            }
        }
    }

    public function isEmpty()
    {
        return empty($this->getProductsList());
    }

    private function getProductsList() : array
    {
        if (!$this->session->has('order')) {
            return [];
        }
        return $this->em
            ->getRepository(Product::class)
            ->findBy(['id' => array_keys($this->session->get('order'))]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $count = 0;
        $items = $this->getItems();
        /** @var Item $item */
        foreach ($items as $item) {
            $count += $item->getCount();
        }
        return $count;
    }

    public function getTotal(): float
    {
        $cost = 0;
        $items = $this->getItems();
        /** @var Item $item */
        foreach ($items as $item) {
            $cost += $item->getCost();
        }
        return $cost;
    }

    public function clear()
    {
        if ($this->session->has('order')) {
            $this->session->remove('order');
        }
    }


    public function removeItemByProduct(Product $product)
    {
        if (!$this->session->has('order')) {
            return [];
        }
        $products = $this->session->get('order');
        if (!empty($products[$product->getId()])) {
            unset($products[$product->getId()]);
            $this->session->set('order', $products);
        }
    }

    public function updateItem(Item $item)
    {
        if (!$this->session->has('order')) {
            return [];
        }
        $product = $item->getProduct();
        $products = $this->session->get('order');
        if (!empty($products[$product->getId()])) {
            $products[$product->getId()] = $item->getCount();
            $this->session->set('order', $products);
        }
    }
}