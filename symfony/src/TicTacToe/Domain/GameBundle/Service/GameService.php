<?php

namespace TicTacToe\Domain\GameBundle\Service;

use League\Tactician\CommandBus;
use TicTacToe\Domain\GameBundle\Command\RegisterGame;
use TicTacToe\Domain\GameBundle\Query\GetGame;
use TicTacToe\Domain\MoveBundle\Entity\Move;
use TicTacToe\Domain\MoveBundle\Exception\InvalidMoveException;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\GameBundle\Exception\DomainException;
use TicTacToe\InfrastructureBundle\ORM\IRepository;
use TicTacToe\InfrastructureBundle\ORM\IUnitOfWork;

class GameService
{
    const RESULT_PLAYER_1_WON = 1;
    const RESULT_PLAYER_2_WON = 2;
    const RESULT_TIE = 3;

    const RESULT_IN_PROGRESS = 0;

	/**
	 * @var IRepository
	 */
	private $gameRepository;

	/**
	 * @var IUnitOfWork
	 */
	private $uow;

    /**
     * @var CommandBus
     */
	private $commandBus;

    private $result = self::RESULT_IN_PROGRESS;
    private $player1;
    private $player2;
    private $board = [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0],
    ];
    private $movesLeft = 9;

	public function __construct(IUnitOfWork $uow, IRepository $gameRepository, CommandBus $commandBus)
	{
		$this->uow = $uow;
		$this->gameRepository = $gameRepository;
		$this->commandBus = $commandBus;
	}

	/**
	 * Returns game by id
	 *
	 * @param int $id
	 * @return Game
	 */
	public function getGame(int $id) : ?Game
	{
	    $query = new GetGame($id);

		return $this->commandBus->handle($query);
	}

    /**
     * Creates a Game
     *
     * @param $player1
     * @param $player2
     * @return Game
     */
	public function create(Player $player1,Player $player2)
	{
	    $this->player1 = $player1;
	    $this->player2 = $player2;

		$command = new RegisterGame($player1,$player2);

		return $this->commandBus->handle($command);
	}

    /**
     * Updates a Game
     *
     * @param Game $game
     * @return Game
     */
    public function update(Game $game) : Game
    {
        $this->gameRepository->update($game);
        $this->uow->commit();

        return $game;
    }

    /**
     * Returns the array map for check the matrix status
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Makes a move for Player1
     * @param Game $game
     */
    public function player1Move(Game $game)
    {
        $move = $game->getMoves()->last();
        $this->validateMove($move);
        $this->movesLeft--;
        $this->board = $this->move($move,$this->board,'X');
        $this->updateResult($move->getPlayer());
    }

    /**
     * Makes a Move for Player2
     * @param Game $game
     */
    public function player2Move(Game $game)
    {
        $move = $game->getMoves()->last();
        $this->validateMove($move);
        $this->movesLeft--;
        $this->board = $this->move($move,$this->board,'O');
        $this->updateResult($move->getPlayer());
    }

    /**
     * Validates if Move can be executed
     *
     * @param Move $move
     * @throws InvalidMoveException
     */
    private function validateMove(Move $move)
    {
        if ($this->board[$move->getX()][$move->getY()] !== 0) {
            throw new InvalidMoveException($move->getX(), $move->getY());
        }

        if (!isset($this->board[$move->getX()][$move->getY()])) {
            throw new InvalidMoveException($move->getX(), $move->getY());
        }
    }

    //TODO: This function should be an event in every move
    /**
     * Update de Matrix status for
     * @param Player $player
     */
    private function updateResult(Player $player)
    {
        if ($this->isBoardWithWinnerCondition()) {
            if ($player === $this->player1) {
                $this->result = self::RESULT_PLAYER_1_WON;
            } else {
                $this->result = self::RESULT_PLAYER_2_WON;
            }
        } elseif (0 === $this->movesLeft) {
            $this->result = self::RESULT_TIE;
        }
    }

    /**
     * Gets the integer value for game result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Checks into matrix if this player has won
     *
     * @return bool
     */
    private function isBoardWithWinnerCondition()
    {
        if ($this->board[0][0] === $this->board[0][1] && $this->board[0][1] === $this->board[0][2] && $this->board[0][0] !== 0) {
            return true;
        }

        if ($this->board[1][0] === $this->board[1][1] && $this->board[1][1] === $this->board[1][2] && $this->board[1][0] !== 0) {
            return true;
        }

        if ($this->board[2][0] === $this->board[2][1] && $this->board[2][1] === $this->board[2][2] && $this->board[2][0] !== 0) {
            return true;
        }

        if ($this->board[2][0] === $this->board[1][0] && $this->board[1][0] === $this->board[0][0] && $this->board[2][0] !== 0) {
            return true;
        }

        if ($this->board[2][1] === $this->board[1][1] && $this->board[1][1] === $this->board[0][1] && $this->board[2][1] !== 0) {
            return true;
        }

        if ($this->board[2][2] === $this->board[1][2] && $this->board[1][2] === $this->board[0][2] && $this->board[2][2] !== 0) {
            return true;
        }

        if ($this->board[0][0] === $this->board[1][1] && $this->board[1][1] === $this->board[2][2] && $this->board[0][0] !== 0) {
            return true;
        }

        if ($this->board[0][2] === $this->board[1][1] && $this->board[1][1] === $this->board[2][0] && $this->board[0][2] !== 0) {
            return true;
        }

        return false;
    }

    /**
     * Function that write the position of the player into main board
     *
     * @param Move $move
     * @param array $board
     * @param string $token
     * @return array
     */
    public function move(Move $move,array $board, string $token)
    {
        $board[$move->getX()][$move->getY()] = $token;
        return $board;
    }

    //TODO: This function should be an event in every move
    /**
     * Checks if game has a winner
     *
     * @return bool
     */
    public function isFinished()
    {
        switch ($this->getResult()) {
            case self::RESULT_PLAYER_1_WON:
            case self::RESULT_PLAYER_2_WON:
            case self::RESULT_TIE:
                return true;

            default:
                return false;
        }
    }
}
