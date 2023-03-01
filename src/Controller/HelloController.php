<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController{
    // creer notre action (saluer les gens)

    /**
     * @Route("/hello", name="hello")
     */
    public function hello(): Response{
        echo "Hello Word";
        return new Response();
    }

    /**
     * @Route("/hello/{name}",name = "hello_name")
     */
    public function name($name): Response{
        echo "Hello ".$name;
        return new Response();
    }
}