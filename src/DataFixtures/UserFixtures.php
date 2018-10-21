<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \Datetime;


class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        
            $user1 = new User();
            $user1->setEmail('adeline.test@gmail.com');
            $user1->setRoles(['ROLE_ADMIN']);
            $user1->setLastName('Delbecq');
            $user1->setFirstname('Adeline');
            $user1->setUsername('Adybou');
            $user1->setPassword($this->encoder->encodePassword($user1, 'adybou'));

            $manager->persist($user1);

            $user2 = new User();
            $user2->setEmail('mod.test@gmail.com');
            $user2->setRoles(['ROLE_MOD']);
            $user2->setLastName('Mod');
            $user2->setFirstname('Mod');
            $user2->setUsername('Moderateur');
            $user2->setPassword($this->encoder->encodePassword($user2, 'moderateur'));

            $manager->persist($user2);

            $user3 = new User();
            $user3->setEmail('bruh.test@gmail.com');
            $user3->setRoles(['ROLE_USER']);
            $user3->setLastName('bruh');
            $user3->setUsername('Bruh');
            $user3->setFirstname('bruhbruh');
            $user3->setPassword($this->encoder->encodePassword($user3, 'bruhmyducky'));

         
            $manager->persist($user3);
    

        $manager->flush();
    }
}
