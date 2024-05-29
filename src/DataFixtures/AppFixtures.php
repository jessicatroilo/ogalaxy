<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\AppProvider;
use App\Entity\Expedition;
use App\Entity\User;


class AppFixtures extends Fixture
{
    private $provider;

    public function __construct(AppProvider $provider)
    {
        $this->provider = $provider;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $planets = $this->provider->getPlanets();

        foreach ($planets as $planetData) {
            $planet = new Expedition();
            $planet->setTitle($planetData['title']);
            $planet->setDestination($planetData['destination']);
            $planet->setDescription($planetData['description']);
            $planet->setPicture($planetData['picture']);
            $planet->setPrice($planetData['price']);
            $departureDate = \DateTime::createFromFormat('d / m / Y', $planetData['departure']);
            if ($departureDate !== false) {
                $planet->setDeparture($departureDate);
            }
            $planet->setDuration($planetData['duration']);
            $planet->setPassenger($planetData['passenger']);



            $manager->persist($planet);
        }

        $nbUsers = 10;
        for ($currentUser = 0; $currentUser < $nbUsers; $currentUser++) {
            $user = new User();

            $createdAt = $faker->dateTimeBetween('-1 year', 'now');
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');

            $user
                ->setPseudo($faker->userName())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setEmail($faker->email())
                // hash password here are all: admin
                ->setPassword($faker->randomElement(['$2y$13$rUb2D.u2XwhwtNKYZXuAW.xp.pJu5PBTr96dzCmGW5PHTHEAG4/Ri', '$2y$13$.0qVsWRRJnr0coywFpBq1etrfpKxEyV3REdX82Bj4PAaFNG1VZX0W', '$2y$13$critPolJjcaGzs/GVSfyGeYiEd7wIElvK56Fr4ASe9adX52sLwgam']))
                ->setRoles($faker->randomElement([["ROLE_USER"], ["ROLE_ADMIN"]]))
                ->setCreatedAt(new \DateTimeImmutable($createdAt->format('Y-m-d H:i:s')))
                ->setUpdatedAt(new \DateTimeImmutable($updatedAt->format('Y-m-d H:i:s')));

            $manager->persist($user);
        }


        $manager->flush();
    }
}
