<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\GameBundle\Command;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\GameBundle\Exception\DomainException;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class RegisterGameHandler
{
    /**
     * @var IRepository
     */
    private $gameRepository;

    /**
     * @var IUnitOfWork
     */
    private $uow;

    public function __construct(IUnitOfWork $uow, IRepository $gameRepository)
    {
        $this->uow = $uow;
        $this->gameRepository = $gameRepository;
    }

    public function handle(RegisterGame $command)
    {
        $game = new Game($command->getPlayer1(),$command->getPlayer2());

        $this->gameRepository->add($game);
        $this->uow->commit();

        return $game;
    }

}