<?php

namespace TicTacToe\Domain\PlayerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\PlayerBundle\Exception\DomainException;
use TicTacToe\Domain\PlayerBundle\Exception\InvalidPlayerNameException;
use TicTacToe\InfrastructureBundle\ORM\IEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="players")
 * @ORM\HasLifecycleCallbacks()
 */
class Player implements IEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=120)
     * @var string
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity="TicTacToe\Domain\GameBundle\Entity\Game", inversedBy="players")
     * @ORM\JoinTable(name="players_games")
     * @var ArrayCollection|PersistentCollection|Game[]
     */
    private $games;

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
     * Player constructor.
     *
     * @param string $name
     * @param string $username
     * @throws InvalidPlayerNameException
     */
	public function __construct(string $name,string $username)
	{
        if (empty($name) || empty($username)) {
            throw new InvalidPlayerNameException($name);
        }
		$this->setName($name)
            ->setUsername($username)
			->setCreated(new \DateTime());

        $this->games = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return int
     */
	public function getId() : int
	{
		return $this->id;
	}

    /**
     * Get name
     *
     * @return string
     */
	public function getName() : string
	{
		return $this->name;
	}

    /**
     * Set name
     *
     * @param string $name
     * @return Player
     */
	public function setName(string $name) : Player
	{
		$this->name = $name;
		return $this;
	}

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Player
     */
    public function setUsername($username) : Player
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * Adds Game to Player
     *
     * @param Game $game
     * @throws DomainException
     */
    public function addGame(Game $game)
    {
        if ($this->hasGame($game)) {
            throw new DomainException('Game already added');
        }
        $this->games->add($game);
    }

    /**
     * Removes Game to Player
     *
     * @param Game $game
     * @throws DomainException
     */
    public function removeGame(Game $game)
    {
        if (!$this->hasGame($game)) {
            throw new DomainException('Game not exists');
        }
        $this->games->removeElement($game);
    }


    /**
     * Check if Player has Game
     *
     * @param Game $game
     * @return bool
     */
    public function hasGame(Game $game) : bool
    {
        return $this->games->contains($game);
    }

    /**
     * Get Games
     *
     * @return  ArrayCollection|PersistentCollection|Game[]
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Get CreationDate
     *
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }

    /**
     *
     * @param $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Player
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
    public function updateModifiedDatetime()
    {
        $this->setUpdated(new \DateTime());
    }
}
