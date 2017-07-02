<?php

namespace TicTacToe\Domain\GameBundle\Doctrine;

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
    public function createGameRepository() : IRepository
    {
        return $this->doctrine->getRepository('TicTacToeDomainGameBundle:Game');
    }

	/**
	 * @return IUnitOfWork
	 */
	public function createUnitOfWork() : IUnitOfWork
	{
		return new UnitOfWork($this->doctrine);
	}
}
