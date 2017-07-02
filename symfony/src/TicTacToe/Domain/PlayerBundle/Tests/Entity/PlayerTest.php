<?php

namespace TicTacToe\Domain\PlayerBundle\Tests\Entity;

use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\PlayerBundle\Tests\TestCaseBase;

class PlayerTest extends TestCaseBase
{
	public function testConstruct()
	{
		// act
        $player = new Player('Player 1', 'player1');
        // assert
        $this->assertInstanceOf('TicTacToe\Domain\PlayerBundle\Entity\Player', $player);
        $this->assertEquals('Player 1', $player->getName());
        $this->assertEquals('player1', $player->getUsername());
	}
}
