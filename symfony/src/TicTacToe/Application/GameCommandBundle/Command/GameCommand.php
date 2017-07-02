<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo
 * Date: 30/06/2017
 * Time: 23:28
 */

namespace TicTacToe\Application\GameCommandBundle\Command;

use Monolog\Logger;
use PHPGames\Console\Helper\Board;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use TicTacToe\Application\GameCommandBundle\Exception\ExitGameException;
use TicTacToe\Domain\GameBundle\Entity\Game;
use TicTacToe\Domain\GameBundle\Service\GameService;
use TicTacToe\Domain\MoveBundle\Exception\InvalidMoveException;
use TicTacToe\Domain\MoveBundle\Service\MoveService;
use TicTacToe\Domain\PlayerBundle\Entity\Player;
use TicTacToe\Domain\PlayerBundle\Service\PlayerService;

class GameCommand extends ContainerAwareCommand
{
    const PLAYER_1 = 1;
    const PLAYER_2 = 2;

    /** @var  InputInterface */
    private $input;
    /** @var  OutputInterface */
    private $output;
    /** @var  Logger */
    protected $logger;
    /** @var  PlayerService */
    protected $playerService;
    /** @var  GameService */
    protected $gameService;
    /** @var  MoveService */
    protected $moveService;
    protected $humanName = 'Player1';
    protected $humanName2 = 'Player2';

    protected function configure()
    {
        $this
            ->setName('tictactoe:game:start')

            ->setDescription('Technical interview app for eDreams.')

            ->setHelp("This command starts an amazing Tic Tac Toe Game")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        //Retrieving some services that we need for execute
        $this->logger = $this->getContainer()->get('logger');
        $this->playerService = $this->getContainer()->get('tic_tac_toe.domain.service.player');
        $this->gameService = $this->getContainer()->get('tic_tac_toe.domain.service.game');
        $this->moveService = $this->getContainer()->get('tic_tac_toe.domain.service.move');

        //Checking if standard users exists, if not we gonna create both.
        $player1 = $this->playerService->findPlayerByName('Player1');
        $player2 = $this->playerService->findPlayerByName('Player2');

        if (!$player1) {
            $player2 = $this->playerService->save('Player1','player1');
        }elseif(!$player2) {
            $player2 = $this->playerService->save('Player2','player2');
        }

        $this->logger->info('Creating the tic tac toe game with default user '.$player1->getName().' and '.$player2->getName());
        $game = $this->gameService->create($player1,$player2);
        $board = new Board($output, $this->getApplication()->getTerminalDimensions(), 3);

        $last_player = $player1;

        $question = $this->createCoordinatesQuestion();
        $this->logger->info('--------------- START GAME ------------------');
        try {
            while (true) {
                $this->handleHumanMove($game, $question, $last_player, $board);

                if ($this->gameService->isFinished()) {
                    $this->logger->info('---------------- END GAME ------------------');
                    $game = $this->handleEndOfMatch($game,$player2, $player1, $board); //TODO: Tell to game service who is the winner for get saved.
                } else {
                    if ($last_player === $player1) {
                        $last_player = $player2;
                    }else{
                        $last_player = $player1;
                    }
                }
            }
        } catch (ExitGameException $e ) {
            $this->output->writeln("<question>See you soon!</question>");
        } catch (\Exception $e) {
            $this->output->writeln('Unexpected <error>' . $e->getMessage() . '</error>');
        }
    }

    private function humanMove(Game $game, Player $player, $coord, Board $board)
    {
        $player = $this->playerService->findPlayerByName($player->getName());
        $this->moveService->create($game, $player, $coord[0], $coord[1]);

        if($player->getName() === 'Player1')
            $this->gameService->player1Move($game);
        else
            $this->gameService->player2Move($game);

        $this->logger->debug(sprintf('  Human move (%s,%s)', $coord[0], $coord[1]));

        if($player->getName() === 'Player1')
            $board->updateGame($coord[0], $coord[1], self::PLAYER_1);
        else
            $board->updateGame($coord[0], $coord[1], self::PLAYER_2);
    }

    protected function handleEndOfMatch(Game $game, Player $p2, Player $p1, Board $board)
    {
        $this->writeResult($game);
        $this->askToPlayAgain();

        $newGame = $this->newGame($board, $p1, $p2);

        return $newGame;
    }

    private function askToPlayAgain()
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Play again? <comment>(y/n)</comment><info>[y]</info>', true);
        if (!$helper->ask($this->input, $this->output, $question)) {
            throw new ExitGameException();
        }
    }

    private function handleHumanMove(Game $game, Question $question, Player $player, Board $board)
    {
        $helper = $this->getHelper('question');
        $count = 0;
        while (true) {
            $humanMove = $helper->ask($this->input, $this->output, $question);
            $coord     = explode(',', $humanMove);
            try {
                $this->humanMove($game, $player, $coord, $board);
            } catch (InvalidMoveException $e) {
                $this->writeInvalidMoveMessage($count, $humanMove);
                $count++;
                continue;
            }
            break;
        }
    }

    private function writeResult(Game $game)
    {
        $message = 'Winner was %s';

        if ($this->gameService->getResult() === GameService::RESULT_PLAYER_1_WON) {
            $message = sprintf($message, 'Player 1');
            $this->gameService->update($game);
        } elseif ($this->gameService->getResult() === GameService::RESULT_PLAYER_2_WON) {
            $message = sprintf($message, 'Player 2');
        } else {
            $message = sprintf($message, 'Tie!');
        }

        $this->logger->info($message);

        $this->output->writeln($message);
    }

    private function writeInvalidMoveMessage($retries, $humanMove)
    {
        $message = sprintf("<comment>Move %s is an invalid move, choose another one</comment>", $humanMove);
        if ($retries > 2) {
            $message = sprintf("<comment>Same move, again %s?</comment>", $humanMove);
        }

        $this->output->writeln($message);
    }

    private function createCoordinatesQuestion()
    {
        $question = new Question('Enter the coordinates <info>(e.g: 0,0)</info>: ', null);
        $question->setValidator(
            function ($answer) {
                if (!preg_match('/\d,\d/', $answer)) {
                    throw new \RuntimeException('Invalid format, they should be in the format x,y');
                }
                return $answer;
            }
        );

        $question->setAutocompleterValues(['0,0', '0,1', '0,2', '1,0', '1,1', '1,2', '2,0', '2,1', '2,2']);

        return $question;
    }

    protected function newGame(Board $board,Player $p1,Player $p2)
    {
        $board->initGame();
        return $this->gameService->create($p1,$p2);
    }


}