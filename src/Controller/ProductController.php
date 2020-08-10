<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
//use App\Service\Cart\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{

    /**
     * @param Product $product
     * @return Response
     */
    public function index(Product $product)
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function addVote(Product $product, Request $request, EntityManagerInterface $em)
    {
        $voteVal = $request->request->get('vote');
        $token = $request->request->get('token');
        if (!$this->isCsrfTokenValid('add_to_cart', $token)) {
            throw new BadRequestException('Wrong CSRF token. Are you robot?');
        }
        $vote = new Rating();
        $vote->setValue($voteVal);
        $product->addRating($vote);
        $em->persist($vote);
        $em->persist($product);
        $em->flush();
        return new Response($product->getCurrentRating());
    }

    public function addToCart(Product $product, SessionInterface $session)
    {
        $session->start();
        $products = $session->has('order') ? $session->get('order') : [];
        if (empty($products[$product->getId()])) {
            $products[$product->getId()] = 0;
        }

        $products[$product->getId()]++;

        $session->set('order', $products);
        return new Response();
    }

    public function showCart(SessionInterface $session, EntityManagerInterface $em)
    {
        $products = [];
        if ($session->has('order')) {
            $products = $em->getRepository(Product::class)->findBy(['id' => array_keys($session->get('order'))]);
        }
        return $this->render('parts/cart_modal.html.twig', [
            'products' => $products,
        ]);
    }
}
