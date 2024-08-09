<?php

namespace xoapp\jobs\extension;

use pocketmine\player\Player;

class Worker
{

    public function __construct(
        private readonly Player $player,
        private int $level = 0,
        private int $progress = 0,
        private readonly int $max_progress = 10
    )
    {
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getName(): string
    {
        return $this->player->getName();
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function increaseLevel(): void
    {
        $this->level++;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function increaseProgress(): void
    {
        $this->progress++;
    }

    public function resetProgress(): void
    {
        $this->progress = 0;
    }

    public function getMaxProgress(): int
    {
        return $this->max_progress;
    }

    public function toArray(): array
    {
        return [
            'level' => $this->level,
            'progress' => $this->progress,
        ];
    }
}