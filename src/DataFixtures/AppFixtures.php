<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create();

        $client1 = new Client();
        $client1->setName('Orange');
        $manager->persist($client1);

        $client2 = new Client();
        $client2->setName('Bouygues');
        $manager->persist($client2);

        for ($user_count = 0; $user_count < 10; $user_count++) {
            $user = new User();
            $passHash = $this->encoder->hashPassword($user, 'perenoel');
            $user->setUsername($fake->userName)
                ->setPassword($passHash)
                ->setRoles(['ROLE_ADMIN']);
            if ($user_count % 2 === 0) {
                $client1->addUser($user);
            }
            else {
                $client2->addUser($user);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
