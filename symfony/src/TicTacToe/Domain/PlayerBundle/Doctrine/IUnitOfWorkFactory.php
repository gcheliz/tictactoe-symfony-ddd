<?php

namespace TicTacToe\Domain\PlayerBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

interface IUnitOfWorkFactory
{
	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork;
}
