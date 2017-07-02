<?php

namespace TicTacToe\Domain\GameBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IRepository;

interface IRepositoryFactory
{
    /**
     * @return IRepository
     */
    public function createGameRepository() : IRepository;
}
