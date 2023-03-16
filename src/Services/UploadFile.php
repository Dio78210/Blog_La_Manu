<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Throwable;

class UploadFile extends AbstractController{

    public function generate_name($length = 20){
        $code = "azertyuikflvhbqiyughfoiqf,fugvhqosgholqsikjhgbgnhkjk;omk";
        $result = "";

        while(strlen($result) < 20){
            $result .=$code[rand(0, strlen($code)-1)];
        }
        return $result;
    }

    public function saveFile($file){

        //recuperation de l'extension du fichier grace a la methode guessExtension()
        $extension = $file->guessExtension();

        //utiliser la methode generate_name pour creer un nom a chaque fichier et le concatener avec l'extension
        $filename = $this->generate_name(30).".".$extension;

        //deplacer le fichier vers le chemin image_dir configurer dans service.yaml
        $file->move($this->getParameter('image_dir'),$filename);

        return '/assets/images/articles/'.$filename;
    }


    public function updateFile($file, $old_file){

        //sauvegarder le fichier recu avant eventuel suppression de l'ancien
        $file_url = $this->saveFile($file);

        //nous allons passer par un TRY/CATCH afin de pouvoir gerer les anomalies
        //--TRY--l'ancien fichier suprimé manuellement dans le dossier public/article
        try{
            //supprime le vieux fichier de mon chemin
            unlink($this->getParameter('static_dir').$old_file);

        }catch(Throwable $th){//si une exeption est levée je ne fais rien je passe simplement a la suite
            //throw $th
        }

        return $file_url;





    }



}