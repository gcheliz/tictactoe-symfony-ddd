<?php

namespace TicTacToe\Domain\GameBundle\Tests\Integration;

use TicTacToe\Domain\GameBundle\Tests\IntegrationTestCaseBase;

class ContainerTest extends IntegrationTestCaseBase
{
	public function testContains_GameService()
	{
		$this->assertInstanceOf('TicTacToe\Domain\GameBundle\Service\GameService', $this->get('tic_tac_toe.domain.service.game'));
	}
}
