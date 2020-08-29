<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class ListController
 * @package App\Controller
 */
class ListController extends AbstractController
{

    /**
     * @param Category $category
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Category $category, SessionInterface $session)
    {
        $session->start();
        return $this->render('list/index.html.twig', [
            'category' => $category
        ]);
    }
}
