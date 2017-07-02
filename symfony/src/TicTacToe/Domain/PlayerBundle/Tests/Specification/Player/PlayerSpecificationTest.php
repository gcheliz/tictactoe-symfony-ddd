<?php

namespace TicTacToe\Domain\PlayerBundle\Tests\Specification;

use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\PlayerBundle\Specification\Player\NameSpecification;
use TicTacToe\Domain\GameBundle\Tests\IntegrationTestCaseBase;

class PlayerSpecificationTest extends IntegrationTestCaseBase
{
	public function testSatisfiedIsShouldBeTrue()
	{
		$specification = new NameSpecification('Player 1');
		$this->assertTrue($specification->isSatisfiedBy(new Player('Player 1','player1')));
	}

	public function testSatisfiedIsShouldBeFalse()
	{
		$specification = new NameSpecification('Player');
		$this->assertFalse($specification->isSatisfiedBy(new Player('Player 1','player1')));
	}
}
