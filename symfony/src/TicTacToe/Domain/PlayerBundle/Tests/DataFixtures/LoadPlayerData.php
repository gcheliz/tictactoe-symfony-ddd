<?php

namespace TicTacToe\Domain\PlayerBundle\Tests\DataFixtures;

use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\Doctrine\DoctrineHelper;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPlayerData implements FixtureInterface
{
	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param \Doctrine\Common\Persistence\ObjectManager $manager
	 * @return void
	 */
	function load(ObjectManager $manager)
	{
		DoctrineHelper::truncate($manager, 'TicTacToe\Domain\PlayerBundle\Entity\Player');

		$player = new Player('Player 1', 'player1');

		$manager->persist($player);
		$manager->flush();
	}
}
