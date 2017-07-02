<?php

namespace TicTacToe\Domain\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use TicTacToe\Domain\MoveBundle\Entity\Move;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\PlayerBundle\Exception\DomainException;
use TicTacToe\InfrastructureBundle\ORM\IEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 * @ORM\HasLifecycleCallbacks()
 */
class Game implements IEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	private $id;

    /**
     * @ORM\ManyToMany(targetEntity="TicTacToe\Domain\PlayerBundle\Entity\Player", mappedBy="games", cascade={"persist", "remove"})
     * @var ArrayCollection|PersistentCollection|Player[]
     */
    private $players;

    /**
     * @ORM\OneToMany(targetEntity="TicTacToe\Domain\MoveBundle\Entity\Move", mappedBy="game", cascade={"persist", "remove"})
     * @var ArrayCollection|PersistentCollection|Move[]
     */
    private $moves;

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
     * Game constructor.
     * @param $player1
     * @param $player2
     */
	public function __construct($player1,$player2)
	{
        $this->setCreated(new \DateTime());
        $this->moves = new ArrayCollection();
        $this->players = new ArrayCollection();
        $this->addPlayer($player1);
        $this->addPlayer($player2);
    }

    /**
     * Get game id
     *
     * @return int
     */
	public function getId() : int
	{
		return $this->id;
	}

    /**
     * Adds player to Game
     *
     * @param Player $player
     * @throws DomainException
     */
    public function addPlayer(Player $player)
    {
        if ($this->hasPlayer($player)) {
            throw new DomainException('Player already added');
        }
        $player->addGame($this);
        $this->players->add($player);

    }

    /**
     * Removes player to Game
     *
     * @param Player $player
     * @throws DomainException
     */
    public function removePlayer(Player $player)
    {
        if (!$this->hasPlayer($player)) {
            throw new DomainException('Player not exists');
        }
        $this->players->removeElement($player);
    }

    /**
     * Check if Player exist in Game
     * @param Player $player
     * @return bool
     */
    public function hasPlayer(Player $player) : bool
    {
        return $this->players->contains($player);
    }

    /**
     * Get Players
     *
     * @return ArrayCollection
     */
    public function getPlayers() : ArrayCollection
    {
        return $this->players;
    }

    /**
     * Add move
     *
     * @param Move $move
     *
     * @return Game
     */
    public function addMove(Move $move)
    {
        $this->moves[] = $move;

        return $this;
    }

    /**
     * Remove move
     *
     * @param Move $move
     */
    public function removeMove(Move $move)
    {
        $this->moves->removeElement($move);
    }

    /**
     * Get moves
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoves()
    {
        return $this->moves;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Game
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
     * @return Game
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
