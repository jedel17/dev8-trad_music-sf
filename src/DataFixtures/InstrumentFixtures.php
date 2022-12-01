<?php

namespace App\DataFixtures;

use App\Entity\Instrument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InstrumentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $flute = new Instrument(); //pour ajouter un instrument
        $flute->setName('Flute'); //pour envoyer les données
        $manager->persist($flute);//

        $guitar = new Instrument();
        $guitar->setName('Guitar');
        $guitar->setIcon('fa-solid fa-guitar');
        $manager->persist($guitar);

        $fiddle = new Instrument();
        $fiddle->setName('Fiddle');
        $manager->persist($fiddle);

        $manager->flush();
    }
}
