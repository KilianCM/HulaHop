<?php


namespace App\Fixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserFixture extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName("Admin");
        $user->setEmail("admin@admin.com");
        $user->setPassword($this->encoder->encodePassword($user, "azerty"));
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return ['user'];
    }
}