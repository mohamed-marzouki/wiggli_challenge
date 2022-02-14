<?php

namespace App\DataFixtures;

use App\Entity\Group;
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
            $group = (new Group())
                ->setName('Name' . $i)
                ->setDescription('Descirpiton' . $i);
            $manager->persist($group);
        }
        $manager->flush();
    }
}
