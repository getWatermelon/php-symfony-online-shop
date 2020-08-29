<?php
declare(strict_types=1);


namespace App\Controller;

use App\Service\Search\SearcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * @var SearcherInterface
     */
    private $searcher;

    /**
     * SearchController constructor.
     * @param SearcherInterface $searcher
     */
    public function __construct(SearcherInterface $searcher)
    {
        $this->searcher = $searcher;
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $query = $request->query->get('query');
        $articles = $this->searcher->searchByQuery($query);
        return $this->render('search/index.html.twig', [

            'products' => $articles,
        ]);
    }
}
