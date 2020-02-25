<?php


namespace App\Fixtures;


use App\Entity\Category;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("CategoryTest");
        $manager->persist($category);

        for ($i = 0; $i < 20; $i++) {
            $game = new Game();
            $game->setName('Game-'.$i);
            $game->setRecommendedAge($i + 3);
            $game->setDescription("This is a game description. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum");
            $game->setImageUrl("https://images.pexels.com/photos/776654/pexels-photo-776654.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260");
            $game->setCategory($category);
            $game->setPartyTime(2);
            $game->setIsBorrowed(false);
            $manager->persist($game);
        }

        $manager->flush();
    }
}