<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:15
 */

namespace TicTacToe\Domain\PlayerBundle\Query;

use TicTacToe\Domain\PlayerBundle\Specification\Player\NameSpecification;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class GetPlayerByNameHandler
{
    /**
     * @var IRepository
     */
    private $playerRepository;

    /**
     * @var IUnitOfWork
     */
    private $uow;

    public function __construct(IUnitOfWork $uow, IRepository $playerRepository)
    {
        $this->uow = $uow;
        $this->playerRepository = $playerRepository;
    }

    public function handle(GetPlayerByName $command)
    {
        return $this->playerRepository->findBySpecification(new NameSpecification($command->getName()));
    }
}