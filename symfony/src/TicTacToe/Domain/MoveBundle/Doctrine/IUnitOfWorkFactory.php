<?php

namespace TicTacToe\Domain\MoveBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

interface IUnitOfWorkFactory
{
	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork;
}
