<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 01/07/2017
 * Time: 16:21
 */

namespace TicTacToe\Domain\MoveBundle\Command;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\MoveBundle\Exception\DomainException;
use TicTacToe\Domain\PlayerBundle\Entity\Player;

class RegisterMove
{
    private $game;
    private $player;
    private $x;
    private $y;

    public function __construct(Game $game, Player $player, int $x, int $y)
    {
        if (!$game instanceof Game)
            throw new DomainException(sprintf('Not a valid Game'));
        elseif (!$player instanceof Player)
            throw new DomainException(sprintf('Not a valid Player'));
        $this->game = $game;
        $this->player = $player;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }
}