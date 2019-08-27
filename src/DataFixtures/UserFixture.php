<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setLastName('Alexis');
        $user1->setFirstName('Allart');
        $user1->setEmail('alexis.allart@gmail.com');
        $user1->setPassword('1234');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setLastName('Natacha');
        $user2->setFirstName('Rome');
        $user2->setEmail('natacha.rome@gmail.com');
        $user2->setPassword('1234');
        $manager->persist($user2);

        $user3 = new User();
        $user3->setLastName('Wahiba');
        $user3->setFirstName('Fay');
        $user3->setEmail('wahiba.fay@gmail.com');
        $user3->setPassword('1234');
        $manager->persist($user3);


        $manager->flush();

        $this->addReference('user1',$user1);
        $this->addReference('user2',$user2);
        $this->addReference('user3',$user3);

    }
}
