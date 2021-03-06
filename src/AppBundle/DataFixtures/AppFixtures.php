<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // create 10 Uers
        for ($i = 0; $i < 20; $i++) {

            $user = new User();

            $user->setEmail('user+' . $i . '@gmail.com');
            $user->setPlainPassword('secret');
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}