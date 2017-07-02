<?php

namespace TicTacToe\InfrastructureBundle\ORM;

interface ISpecification
{
	/**
	 * @param IEntity $object
	 * @return boolean
	 */
	public function isSatisfiedBy(IEntity $object);
}
