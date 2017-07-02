<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:15
 */

namespace TicTacToe\Domain\PlayerBundle\Command;

use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class RegisterPlayerHandler
{
    /**
     * @var IRepository
     */
    private $playerRepository;

    /**
     * @var IUnitOfWork
     */
    private $uow;

    public function __construct(IUnitOfWork $uow, IRepository $playerRepository)
    {
        $this->uow = $uow;
        $this->playerRepository = $playerRepository;
    }

    public function handle(RegisterPlayer $command)
    {
        $player = new Player($command->getName(),$command->getUsername());

        $this->playerRepository->add($player);
        $this->uow->commit();

        return $player;
    }
}