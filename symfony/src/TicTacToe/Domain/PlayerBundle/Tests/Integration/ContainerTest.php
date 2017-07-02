<?php

namespace TicTacToe\Domain\PlayerBundle\Tests\Integration;

use TicTacToe\Domain\PlayerBundle\Tests\IntegrationTestCaseBase;

class ContainerTest extends IntegrationTestCaseBase
{
	public function testContains_PlayerService()
	{
		$this->assertInstanceOf('TicTacToe\Domain\PlayerBundle\Service\PlayerService', $this->get('tic_tac_toe.domain.service.player'));
	}
}
