<?php

namespace TicTacToe\Domain\MoveBundle\Service;

use League\Tactician\CommandBus;
use TicTacToe\Domain\MoveBundle\Command\RegisterMove;
use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class MoveService
{
	/**
	 * @var IRepository
	 */
	private $moveRepository;

	/**
	 * @var IUnitOfWork
	 */
	private $uow;

    /**
     * @var CommandBus
     */
	private $commandBus;

	public function __construct(IUnitOfWork $uow, IRepository $moveRepository, CommandBus $commandBus)
	{
		$this->uow = $uow;
		$this->moveRepository = $moveRepository;
		$this->commandBus = $commandBus;
	}

    /**
     * @param Game $game
     * @param Player $player
     * @param int $x
     * @param int $y
     */
	public function create(Game $game, Player $player, int $x, int $y)
	{
		$command = new RegisterMove($game,$player,$x,$y);

		$this->commandBus->handle($command);
	}
}
