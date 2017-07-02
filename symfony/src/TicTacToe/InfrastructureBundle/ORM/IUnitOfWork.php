<?php

namespace TicTacToe\InfrastructureBundle\ORM;

interface IUnitOfWork
{
	public function commit();
}
