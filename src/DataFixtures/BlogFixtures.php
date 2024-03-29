<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\profile;
use App\Entity\Adresse;
use App\Entity\Category;
use App\Entity\User;
use EsperoSoft\Faker\Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();

        // $users = [];

        // for ($i=0; $i < 100; $i++) { 

        //     $user = (new User())->setFullName($faker->full_name())
        //     ->setEmail($faker->email())
        //     ->setPassword(sha1("azertyuiop"))
        //     ->setCreatedAt($faker->dateTimeImmutable());

        //     $address = (new Adresse())->setStreet($faker->streetAddress())
        //     ->setCodePostal($faker->codepostal())
        //     ->setCity($faker->city())
        //     ->setCountry($faker->country())
        //     ->setCreatedAt($faker->dateTimeImmutable());

        //     $profile = (new Profile())->setPicture($faker->image())
        //     ->setCoverPicture($faker->image())
        //     ->setDescription($faker->text(60))
        //     ->setCreatedAt($faker->dateTimeImmutable());

        //     $user->addAdress($address);
        //     $user->setProfile($profile);

        //     $users[] = $user;

        //     $manager->persist($address);
        //     $manager->persist($profile);
        //     $manager->persist($user);
        // }

        // $categories = [];

        $names = [
            "Developpement",
            "SEO Réferencement naturel",
            "Design",
            "Système et réseaux",
            "E-Marketing",
            "Gestion de projet"
        ];

        for ($i=0; $i < count($names) ; $i++) { 

            $category = (new Category())->setName($names[$i])
            ->setDescription("Description de : ".$names[$i])
            ->setimageUrl($faker->image())
            ->setCreatedAt($faker->dateTimeImmutable());

            // $categories[] = $category;
            $manager->persist($category);
        }

        // // for ($i=0; $i <300 ; $i++) { 

        // //     $article = (new Article())->setTitle($faker->description(30))
        // //     ->setContent($faker->text(5,10))
        // //     ->setImageUrl($faker->image())
        // //     ->setCreatedAt($faker->dateTimeImmutable())
        // //     ->setAuthor($users[rand(0,count($users)-1)])
        // //     ->addCategory($categories[rand(0, count($categories)-1)]);

        // //     $manager->persist($article);
        // }

        $manager->flush();
    }
}
