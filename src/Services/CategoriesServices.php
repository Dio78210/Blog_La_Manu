<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoriesServices{

    private $repoCat;
    private $requestStack;


    public function __construct(CategoryRepository $repoCat, RequestStack $requestStack){

        $this->repoCat = $repoCat;
        $this->requestStack = $requestStack;
    }

    //mise a jour de la session
    public function updateSession(){
        $session = $this->requestStack->getSession();//recup de la session
        $categories = $this->repoCat->findAll();// recup de toutes les categories
        $session->set("categories", $categories);//on stock les categories dans la session
    }



















}