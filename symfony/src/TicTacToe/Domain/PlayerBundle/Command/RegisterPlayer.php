<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:15
 */

namespace TicTacToe\Domain\PlayerBundle\Command;

use TicTacToe\Domain\PlayerBundle\Exception\DomainException;

class RegisterPlayer
{
    private $name;
    private $username;

    public function __construct(string $name, string $username)
    {
        if (empty($name) || empty($username))
            throw new DomainException(sprintf('Name and username can\'t be empty.'));
        $this->name = $name;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}