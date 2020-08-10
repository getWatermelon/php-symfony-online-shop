<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{

    public function index(Category $category)
    {
        return $this->render('list/index.html.twig', [
            'category' => $category
        ]);
    }
}
