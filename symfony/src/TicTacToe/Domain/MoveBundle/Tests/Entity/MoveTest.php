<?php

namespace TicTacToe\Domain\MoveBundle\Tests\Entity;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\MoveBundle\Entity\Move;
use TicTacToe\Domain\MoveBundle\Tests\TestCaseBase;
use TicTacToe\Domain\PlayerBundle\Entity\Player;

class MoveTest extends TestCaseBase
{
	public function testConstruct()
	{
		// arrange
		$player1 = $this->createPlayer('Player 1','player1');
		$player2 = $this->createPlayer('Player 2','player2');
        $game = $this->createGame($player1,$player2);
        // act
        $move = new Move(2,1,$game,$player1);
        // assert
        $this->assertInstanceOf('TicTacToe\Domain\MoveBundle\Entity\Move', $move);
        $this->assertInstanceOf('TicTacToe\Domain\GameBundle\Entity\Game', $move->getGame());
        $this->assertInstanceOf('TicTacToe\Domain\PlayerBundle\Entity\Player', $move->getPlayer());
        $this->assertEquals(2,$move->getX());
        $this->assertEquals(1,$move->getY());
	}

	private function createPlayer($name,$username)
	{
		return new Player($name, $username);
	}

	private function createGame(Player $player1,Player $player2)
    {
        return new Game($player1,$player2);
    }
}
