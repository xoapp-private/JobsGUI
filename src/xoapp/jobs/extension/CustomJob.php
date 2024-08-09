<?php

namespace xoapp\jobs\extension;

use pocketmine\item\Item;
use pocketmine\player\Player;

abstract class CustomJob
{

    abstract public function getName(): string;

    abstract public function getMaxLevels(): int;

    abstract public function setMaxLevels(int $max_levels): void;

    abstract public function getMoneyPerLevel(): int;

    abstract public function setMoneyPerLevel(int $money_per_level): void;

    abstract public function getWorkers(): array;

    abstract public function addWorker(Worker $worker): void;

    abstract public function getWorker(Player $player): ?Worker;

    abstract public function deleteWorker(string $name): void;

    abstract public function toArray(): array;

    abstract public function getMenuItem(): Item;

}