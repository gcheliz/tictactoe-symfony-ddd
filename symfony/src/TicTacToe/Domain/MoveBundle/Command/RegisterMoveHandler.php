<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\MoveBundle\Command;

use TicTacToe\Domain\MoveBundle\Entity\Move;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class RegisterMoveHandler
{
    /**
     * @var IRepository
     */
    private $moveRepository;

    /**
     * @var IUnitOfWork
     */
    private $uow;

    public function __construct(IUnitOfWork $uow, IRepository $moveRepository)
    {
        $this->uow = $uow;
        $this->moveRepository = $moveRepository;
    }

    public function handle(RegisterMove $command)
    {
        $move = new Move($command->getX(),$command->getY(),$command->getGame(),$command->getPlayer());

        $move->getGame()->addMove($move);
        $this->moveRepository->add($move);
        $this->uow->commit();

        return $move;
    }
}