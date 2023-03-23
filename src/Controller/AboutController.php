<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use App\Services\UploadFile;
use App\Repository\AboutRepository;
use App\Services\CategoriesServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/about")
 */
class AboutController extends AbstractController
{

    private $uploadFile;
    private $em;

    public function __construct(CategoriesServices $categoriesServices, UploadFile $uploadFile, EntityManagerInterface $em){
        $categoriesServices->updateSession();
        $this->uploadFile = $uploadFile;
        $this->em = $em;
    }

    /**
     * @Route("/index", name="app_about_index", methods={"GET"})
     */
    public function index(AboutRepository $aboutRepository): Response
    {
        return $this->render('about/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_about_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AboutRepository $aboutRepository): Response
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $about->setCreatedAt(new \DateTimeImmutable());

            $file = $form["imageFile"]->getData();

            $file_url = $this->uploadFile->saveFile($file);

            $about->setImageUrl($file_url);

            //pousse en BDD
            $this->em->persist($about);
            $this->em->flush();
            // $aboutRepository->add($about, true);

            return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('about/new.html.twig', [
            'about' => $about,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_about_show", methods={"GET"})
     */
    public function show(About $about): Response
    {
        return $this->render('about/show.html.twig', [
            'about' => $about,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_about_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, About $about, AboutRepository $aboutRepository): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $about->setUpdatedAt(new \DateTimeImmutable());// mettre a jour la date quand on update

            $file = $form["imageFile"]->getData();//je recupere l'image update

            if ($file) {//si j'ai une image
                $file_url = $this->uploadFile->updateFile($file, $about->getImageUrl());//mis a jour de l'image

                $about->setImageUrl($file_url);//change l'image avec celle ajouter
            }

            //pousse en BDD
            $this->em->persist($about);
            $this->em->flush();

            return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('about/edit.html.twig', [
            'about' => $about,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_about_delete", methods={"POST"})
     */
    public function delete(Request $request, About $about, AboutRepository $aboutRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->request->get('_token'))) {
            $aboutRepository->remove($about, true);
        }

        return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/", name="app_about_view")
     */
    public function  about(aboutRepository $repoCat): Response{
        // $category = $repoCat->findOneBySlug($slug);
        
        $about = $repoCat->find(2);

        return $this->render('about/view.html.twig',[
            'controller_name' => 'AboutController',
            'about' => $about
        ]);
    }
}
