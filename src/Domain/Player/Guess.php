<?php

namespace Guess\Domain\Player;

use DateTimeInterface;
use Guess\Domain\Game\Game;

class Guess
{
    private int $id;
    private int $guess;
    private DateTimeInterface $createdAt;
    private Game $game;
    private Player $player;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Guess
     */
    public function setId(int $id): Guess
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getGuess(): int
    {
        return $this->guess;
    }

    /**
     * @param int $guess
     * @return Guess
     */
    public function setGuess(int $guess): Guess
    {
        $this->guess = $guess;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return Guess
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Guess
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     * @return Guess
     */
    public function setGame(Game $game): Guess
    {
        $this->game = $game;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Guess
     */
    public function setPlayer(Player $player): Guess
    {
        $this->player = $player;
        return $this;
    }
}
