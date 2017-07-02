<?php

namespace TicTacToe\Domain\PlayerBundle\Specification\Player;

use Doctrine\Common\Collections\Criteria;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\ORM\IEntity;
use TicTacToe\InfrastructureBundle\ORM\ISpecification;
use TicTacToe\InfrastructureBundle\ORM\ISpecificationCriteria;

class NameSpecification implements ISpecification, ISpecificationCriteria
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isSatisfiedBy(IEntity $object) : bool
    {
        if (!$object instanceof Player) {
            throw new \BadMethodCallException(sprintf("I only deal with players, you gave me: %s", get_class($object)));
        }

        return $object->getName() == $this->name;
    }

    public function getCriteria() : Criteria
    {
        return Criteria::create()->where(Criteria::expr()->eq('name', $this->name));
    }
}