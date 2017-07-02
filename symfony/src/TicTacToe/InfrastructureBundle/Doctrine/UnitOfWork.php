<?php

namespace TicTacToe\InfrastructureBundle\Doctrine;

use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;
use Doctrine\Bundle\DoctrineBundle\Registry;

class UnitOfWork implements IUnitOfWork
{
	private $doctrine;

	public function __construct(Registry $doctrine)
	{
		$this->doctrine = $doctrine;
	}

	public function commit()
	{
		$this->doctrine->getManager()->flush();
	}
}
