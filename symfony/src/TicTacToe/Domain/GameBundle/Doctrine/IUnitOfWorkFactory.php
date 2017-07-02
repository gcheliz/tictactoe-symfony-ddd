<?php

namespace TicTacToe\Domain\GameBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

interface IUnitOfWorkFactory
{
	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork;
}
