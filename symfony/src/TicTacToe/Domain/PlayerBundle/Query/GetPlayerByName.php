<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:15
 */

namespace TicTacToe\Domain\PlayerBundle\Query;

use TicTacToe\Domain\PlayerBundle\Exception\DomainException;

class GetPlayerByName
{
    private $name;

    public function __construct(string $name)
    {
        if (empty($name))
            throw new DomainException(sprintf('Name and username can\'t be empty.'));
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}