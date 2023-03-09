<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\CategoriesServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    public function __construct(CategoriesServices $categoriesServices)
    {
        $categoriesServices->updateSession(); //mise à jour de la session
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, EntityManagerInterface $em ): Response
    {

        $contact = new Contact(); //objet contact vide
        $form = $this->createForm(ContactType::class, $contact); //Remplissage de notre Form Contact par des données de $contact

        $form->handleRequest($request);//Analyser la req afin de savoir s'il y a des données pertinante dans cette req

        $session= $request->getSession();//recup une session

        if ($form->isSubmitted() && $form->isValid()) { //Est-ce que le formulaire est soumis et valide ?

            // dd($contact);
            $contact->setCreatedAt(new \DateTimeImmutable()); //la date active lors de la soumission
            $em->persist($contact);//lier les données
            $em->flush();//sauvegarder en BDD
            $contact = new Contact();//redéfinir un nouveua formulaire vide
            $form = $this->createForm(ContactType::class, $contact); //Typer le nouveau formulaire

            $session->getFlashbag()->add('message','message envoyé avec succes');
            $session->set('status','success');

        }elseif($form->isSubmitted() && ! $form->isValid()){
            $session->getFlashbag()->add('message','merci de corriger les erreurs');
            $session->set('status','danger');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact'=>$form->createView()
        ]);
    }
}
