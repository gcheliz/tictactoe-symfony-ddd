<?php

namespace TicTacToe\Domain\GameBundle\Tests\Entity;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\GameBundle\Tests\TestCaseBase;
use TicTacToe\Domain\PlayerBundle\Entity\Player;

class GameTest extends TestCaseBase
{
	public function testConstruct()
	{
		// arrange
		$player1 = $this->createPlayer('Player 1','player1');
		$player2 = $this->createPlayer('Player 2','player2');
		// act
        $game = new Game($player1,$player2);
        // assert
        $this->assertInstanceOf('TicTacToe\Domain\GameBundle\Entity\Game', $game);
        $this->assertEquals(true, $game->getPlayers()->contains($player1));
        $this->assertEquals(true, $game->getPlayers()->contains($player2));
	}

	private function createPlayer($name,$username)
	{
		return new Player($name, $username);
	}
}
