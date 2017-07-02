<?php

namespace TicTacToe\Domain\PlayerBundle\Service;

use League\Tactician\CommandBus;
use TicTacToe\Domain\PlayerBundle\Query\GetAllPlayers;
use TicTacToe\Domain\PlayerBundle\Query\GetPlayer;
use TicTacToe\Domain\PlayerBundle\Query\GetPlayerByName;
use TicTacToe\Domain\PlayerBundle\Command\RegisterPlayer;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\PlayerBundle\Exception\DomainException;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;
use Doctrine\Common\Collections\ArrayCollection;

class PlayerService
{
	/**
	 * @var IRepository
	 */
	private $playerRepository;

	/**
	 * @var IUnitOfWork
	 */
	private $uow;

    /**
     * @var CommandBus
     */
	private $commandBus;

	public function __construct(IUnitOfWork $uow, IRepository $playerRepository, CommandBus $commandBus)
	{
		$this->uow = $uow;
		$this->playerRepository = $playerRepository;
		$this->commandBus = $commandBus;
	}

	/**
	 * Returns player by id
	 *
	 * @param int $id
	 * @return Player
	 */
	public function getPlayer(int $id) : ?Player
	{
	    $query = new GetPlayer($id);

		return $this->commandBus->handle($query);
	}

    /**
     * Returns player by name
     *
     * @param string $name
     * @return Player
     */
    public function findPlayerByName(string $name) : ?Player
    {
        $query = new GetPlayerByName($name);

        return $this->commandBus->handle($query);
    }

	/**
	 * Returns all players
	 *
	 * @return ArrayCollection
	 */
	public function getAllPlayers() : ArrayCollection
	{
		return $this->commandBus->handle(new GetAllPlayers());
	}

    /**
     * Create player
     *
     * @param string $name
     * @param string $username
     * @throws DomainException
     * @return Player
     */
	public function save(string $name,string $username)
    {
        if($this->findPlayerByName($name))
            throw new DomainException(sprintf('Player "%s" exist.', $name));
        
        $player = new RegisterPlayer($name,$username);

        return $this->commandBus->handle($player);
    }
}
