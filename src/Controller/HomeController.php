<?php

namespace App\Controller;


use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices)
    {
        $categoriesServices->updateSession();//mise a jour de la session
    }
    
    /**
     * @Route("/", name="app_home")
     */
    public function home(ArticleRepository $repoArticle): Response
    {
        // $categories = $repoCat->findAll();
        $articles = $repoArticle->findAll();
        
        //var/dump de symfony
        // dd($articles);
        return $this->render("home/index.html.twig", [
            'controller_name' => 'HomeController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{slug}", name="app_single_article")
     */
    public function single(ArticleRepository $repoArticle, string $slug):Response {
        $article = $repoArticle->findOneBySlug($slug);
        // $categories = $repoCat->findAll();
        return $this->render('home/single.html.twig',[
            'controller_name' => 'HomeController',
            'article' => $article
        ]);
    }

    /**
     * @Route("/category/{slug}", name = "app_article_by_category")
     */
    public function  article_by_category(CategoryRepository $repoCat,string $slug): Response{
        $category = $repoCat->findOneBySlug($slug);
        
        // $categories = $repoCat->findAll();

        $articles = [];
        if($category){
            $articles = $category->getArticles()->getValues();
        }
        return $this->render('home/articles_by_category.html.twig',[
            'controller_name' => 'HomeController',
            'articles' => $articles,
            'category'=>$category
        ]);
    }





}
