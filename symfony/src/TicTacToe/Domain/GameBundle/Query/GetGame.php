<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\GameBundle\Query;

use TicTacToe\Domain\GameBundle\Exception\DomainException;

class GetGame
{
    private $id;

    public function __construct(integer $id)
    {
        if (empty($id))
            throw new DomainException(sprintf('Id can\'t be null.'));
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}