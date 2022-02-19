<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = (new User())->setLastName('UserLastName' . $i)
                ->setFirstName('UserFirstName' . $i)
                ->setAge(20 + $i)
                ->setEmail('user' . $i . '@gmail.com')
                ->setPhone('06 00 00 00 00');
            $manager->persist($user);

            $group = (new Group())
                ->setName('Name' . $i)
                ->setDescription('Descirpiton' . $i)
                ->addUser($user);
            $manager->persist($group);
        }
        $manager->flush();
    }
}
