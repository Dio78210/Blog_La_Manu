<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserType;



class RegisterController extends AbstractController{
    

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function index(Request $request, EntityManagerInterface $em ): Response{
        
        $user = new User(); //objet user vide
        $form = $this->createForm(UserType::class, $user); //Remplissage de notre Form user par des données de $user

        $form->handleRequest($request);//Analyser la req afin de savoir s'il y a des données pertinante dans cette req

        $session= $request->getSession();//recup une session

        if ($form->isSubmitted() && $form->isValid()) { //Est-ce que le formulaire est soumis et valide ?

            // dd($user);
            $user->setCreatedAt(new \DateTimeImmutable()); //la date active lors de la soumission
            $em->persist($user);//lier les données
            $em->flush();//sauvegarder en BDD
            $user = new user();//redéfinir un nouveua formulaire vide
            $form = $this->createForm(UserType::class, $user); //Typer le nouveau formulaire

            $session->getFlashbag()->add('message','message envoyé avec succes');
            $session->set('status','success');

        }elseif($form->isSubmitted() && ! $form->isValid()){
            $session->getFlashbag()->add('message','merci de corriger les erreurs');
            $session->set('status','danger');
        }

        return $this->render('register/register.html.twig', [
            'controller_name' => 'RegisterController',
            'user'=>$form->createView()
        ]);
    }
}
