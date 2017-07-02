<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:15
 */

namespace TicTacToe\Domain\PlayerBundle\Query;

use TicTacToe\Domain\PlayerBundle\Exception\DomainException;

class GetPlayer
{
    private $id;

    public function __construct(int $id)
    {
        if (empty($id))
            throw new DomainException(sprintf('Id can\'t be empty.'));
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}