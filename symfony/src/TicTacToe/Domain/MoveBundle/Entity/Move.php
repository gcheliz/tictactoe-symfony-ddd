<?php

namespace TicTacToe\Domain\MoveBundle\Entity;

use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\MoveBundle\Exception\InvalidMoveException;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\InfrastructureBundle\ORM\IEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="moves")
 * @ORM\HasLifecycleCallbacks()
 */
class Move implements IEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	private $id;

    /**
     * @ORM\ManyToOne(targetEntity="TicTacToe\Domain\GameBundle\Entity\Game", inversedBy="moves")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="TicTacToe\Domain\PlayerBundle\Entity\Player", inversedBy="moves")
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     * @var string
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     * @var string
     */
    private $y;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updated;

    /**
     * Move constructor.
     * @param int $x
     * @param int $y
     * @param Game $game
     * @param Player $player
     * @throws InvalidMoveException
     */
	public function __construct(int $x,int $y,Game $game,Player $player)
	{
        if ($x<0 || $x>2 || $y<0 || $y>2) {
            throw new InvalidMoveException($x, $y);
        }

	    $this->setX($x);
	    $this->setY($y);
	    $this->setGame($game);
	    $this->setPlayer($player);
        $this->setCreated(new \DateTime());
    }

    /**
     * @return int
     */
	public function getId() : int
	{
		return $this->id;
	}

    /**
     * Set x
     *
     * @param string $x
     *
     * @return Move
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return string
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param string $y
     *
     * @return Move
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return string
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set game
     *
     * @param Game $game
     *
     * @return Move
     */
    public function setGame(Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set player
     *
     * @param Player $player
     *
     * @return Move
     */
    public function setPlayer(Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Move
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Move
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime() {
        $this->setUpdated(new \DateTime());
    }
}
