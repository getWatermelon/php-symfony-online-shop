<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function index(Product $product)
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

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

//    public function addToCart(Product $product, SessionInterface $session)
//    {
//        $session->start();
//        $products = $session->has('order') ? $session->get('order') : [];
//
//    }
}
