<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Rating;
use App\Form\CommentType;
use App\Service\Cart\Cart;
use App\Service\Cart\Item;
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
    public function index(Product $product, SessionInterface $session)
    {
//        $session->clear();
        $session->start();
        $products = $session->has('history') ? $session->get('history') : [];
        if(empty($products[$product->getId()])) {
            $products[$product->getId()] = $product->getId();
        }
        $session->set('history', $products);

        $form = $this->createForm(CommentType::class, new Comment());
        return $this->render('product/index.html.twig', [
            'form'     => $form->createView(),
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
        foreach ($this->getUser()->getRatings() as &$rating){
            if ($rating->getProduct() == $product){
                $this->getUser()->removeRating($rating);
            }
        }
        $vote = new Rating();
        $vote->setValue($voteVal);
        $vote->setUser($this->getUser());
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

    public function showCart(Cart $cart)
    {
        return $this->render('parts/cart_modal.html.twig', [
            'cart' => $cart
        ]);
    }


    public function removeFromCart(Product $product, Cart $cart)
    {
        $cart->removeItemByProduct($product);
        return new Response($cart->getTotal());
    }

    public function updateItemCount(Product $product, Cart $cart, Request $request)
    {
        $count = $request->request->get('count');
        $item = new Item($product, $count);
        $cart->updateItem($item);
        $result = [
            'item-price' => $item->getCost(),
            'total' => $cart->getTotal()
        ];
        return new Response(json_encode($result));
    }
}


