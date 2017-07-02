<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\GameBundle\Query;

use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class GetGameHandler
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

    public function handle(GetGame $command)
    {
        return $this->gameRepository->findById($command->getId());
    }

}