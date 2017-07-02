<?php
/**
 * InvalidMoveException.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 03/10/14
 */ 
namespace TicTacToe\Domain\MoveBundle\Exception;

class InvalidMoveException extends \Exception
{
    public function __construct ($x, $y)
    {
        parent::__construct(sprintf('The move [%d,%d] is not valid.', $x, $y));
    }
}
