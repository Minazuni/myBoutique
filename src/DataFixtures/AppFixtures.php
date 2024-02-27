<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 10; $i++) {
            $categorie = new Category();
            $categorie->setName('CAT ' . $i);
            $manager->persist($categorie);

            $this->addReference('categorie_' . $i, $categorie);
        }

        $manager->flush();
    }
}
