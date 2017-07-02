<?php

namespace TicTacToe\Domain\MoveBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IRepository;

interface IRepositoryFactory
{
    /**
     * @return IRepository
     */
    public function createMoveRepository() : IRepository;
}
