<?php

namespace TicTacToe\Domain\MoveBundle\Doctrine;

use TicTacToe\InfrastructureBundle\Doctrine\UnitOfWork;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;
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
    public function createMoveRepository() : IRepository
    {
        return $this->doctrine->getRepository('TicTacToeDomainMoveBundle:Move');
    }

	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork
	{
		return new UnitOfWork($this->doctrine);
	}
}
