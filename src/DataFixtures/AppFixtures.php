<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Woofer!');
        $microPost1->setText('The dog-themed social network.');
        $microPost1->setCreated(new DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('This is the title of the second post ever.');
        $microPost2->setText('Isn\'t it thrilling?');
        $microPost2->setCreated(new DateTime());
        $manager->persist($microPost2);

        
        $microPost3 = new MicroPost();
        $microPost3->setTitle('It\'s the third and I\'m already running out of things to say.');
        $microPost3->setText('How do I even fill this text space?');
        $microPost3->setCreated(new DateTime());
        $manager->persist($microPost3);
        
        // executes db loading
        $manager->flush();
    }
}
