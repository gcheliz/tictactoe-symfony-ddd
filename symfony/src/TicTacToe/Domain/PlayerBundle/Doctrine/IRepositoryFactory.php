<?php

namespace TicTacToe\Domain\PlayerBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IRepository;

interface IRepositoryFactory
{
	/**
	 * @return IRepository
	 */
	public function createPlayerRepository() : IRepository;

}
