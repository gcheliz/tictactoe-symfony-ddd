<?php

namespace TicTacToe\Domain\GameBundle\Tests\DataFixtures;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\Doctrine\DoctrineHelper;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGameData implements FixtureInterface
{
	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param \Doctrine\Common\Persistence\ObjectManager $manager
	 * @return void
	 */
	function load(ObjectManager $manager)
	{
		DoctrineHelper::truncate($manager, 'TicTacToe\Domain\GameBundle\Entity\Game');

		$player1 = new Player('Player 1', 'player1');
		$player2 = new Player('Player 2', 'player2');
		$player3 = new Player('Player 3', 'player3');
        new Game($player1,$player2);
        new Game($player2,$player3);

		$manager->persist($player1);
		$manager->persist($player2);
		$manager->persist($player3);
		$manager->flush();
	}
}
