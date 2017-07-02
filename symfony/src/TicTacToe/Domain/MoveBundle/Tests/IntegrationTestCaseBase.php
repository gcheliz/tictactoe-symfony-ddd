<?php

namespace TicTacToe\Domain\MoveBundle\Tests;

use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\Domain\MoveBundle\Tests\Utils\TestsEnvironment;

class IntegrationTestCaseBase extends TestCaseBase
{
	/**
	 * @var TestsEnvironment
	 */
	private static $environment;

	/**
	 * @inheritdoc
	 */
	public static function setUpBeforeClass()
	{
		self::$environment = TestsEnvironment::getInstance();
		self::$environment->runSilent(true);
		self::$environment->addCommand("doctrine:schema:drop", array("--force" => true));
		self::$environment->addCommand("doctrine:schema:create", array());
		self::$environment->addCommand("cache:warmup", array(), true);
		self::$environment->addCommand("doctrine:fixtures:load", array("--fixtures" => __DIR__ . "/DataFixtures"));
		self::$environment->runCommands();
	}

	/**
	 * Returns IoC container
	 *
	 * @param string $service
	 * @return object
	 */
	protected function get($service)
	{
		return self::$environment->getContainer()->get($service);
	}

	/**
	 * Returns repository
	 *
	 * @param $entityName
	 * @return IRepository
	 */
	protected function getRepository($entityName)
	{
		return $this->get(sprintf("tic_tac_toe.domain.repository.%s", strtolower($entityName)));
	}
}
