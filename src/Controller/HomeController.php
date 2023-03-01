<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function home(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        
        //var/dump de symfony
        // dd($articles);
        return $this->render("home/index.html.twig", [
            'controller_name' => 'HomeController',
            'articles' => $articles
        ]);
    }
}
