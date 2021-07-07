<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 20; $i++) {
               $article = new Article();
               $article->setTitle("Titre de l'article n°$i")
                       ->setPrix($i)
                       ->setImage("http://placehold.it/350x150");
   
   
                       $manager->persist($article);
           }
           $manager->flush();
}
}

