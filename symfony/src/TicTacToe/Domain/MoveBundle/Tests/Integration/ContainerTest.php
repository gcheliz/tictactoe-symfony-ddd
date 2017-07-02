<?php

namespace TicTacToe\Domain\MoveBundle\Tests\Integration;

use TicTacToe\Domain\MoveBundle\Tests\IntegrationTestCaseBase;

class ContainerTest extends IntegrationTestCaseBase
{
	public function testContains_GameService()
	{
		$this->assertInstanceOf('TicTacToe\Domain\MoveBundle\Service\MoveService', $this->get('tic_tac_toe.domain.service.move'));
	}
}
