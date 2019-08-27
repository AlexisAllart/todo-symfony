<?php

namespace App\DataFixtures;

use App\Entity\Task;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class TaskFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {

        $task = new Task();
        $task->setUserId($manager->merge($this->getReference('user1')));
        $task->setTitle('Créer les routes');
        $task->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard.');
        $task->setStatus('Fini');
        $manager->persist($task);

        $task= new Task();
        $task->setUserId($manager->merge($this->getReference('user2')));
        $task->setTitle('Coder le front');
        $task->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard .');
        $task->setStatus('En cours');
        $manager->persist($task);

        $task= new Task();
        $task->setUserId($manager->merge($this->getReference('user3')));
        $task->setTitle('Faire la presentation');
        $task->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard .');
        $task->setStatus('A faire');
        $manager->persist($task);

        $manager->flush();
    }
    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }

}
