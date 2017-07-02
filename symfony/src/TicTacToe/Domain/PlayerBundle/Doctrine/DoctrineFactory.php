<?php

namespace TicTacToe\Domain\PlayerBundle\Doctrine;

use TicTacToe\InfrastructureBundle\Doctrine\UnitOfWork;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DoctrineFactory implements IRepositoryFactory, IUnitOfWorkFactory
{
	private $doctrine;

	/**
	 * @param Registry $doctrine
	 */
	public function __construct(Registry $doctrine)
	{
		$this->doctrine = $doctrine;
	}

	/**
	 * @return IRepository
	 */
	public function createPlayerRepository() : IRepository
	{
		return $this->doctrine->getRepository('TicTacToeDomainPlayerBundle:Player');
	}

	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork
	{
		return new UnitOfWork($this->doctrine);
	}
}
