<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\GameBundle\Command;

use TicTacToe\Domain\GameBundle\Exception\DomainException;
use TicTacToe\Domain\PlayerBundle\Entity\Player;

class RegisterGame
{
    private $player1;
    private $player2;

    public function __construct(Player $player1, Player $player2)
    {
        if (!($player1 instanceof Player || $player2 instanceof Player))
            throw new DomainException(sprintf('One of the players is not a Player.'));
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * @return Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @return Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }


}