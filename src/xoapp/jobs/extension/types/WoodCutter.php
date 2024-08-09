<?php

namespace xoapp\jobs\extension\types;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\player\Player;
use xoapp\jobs\extension\CustomJob;
use xoapp\jobs\extension\Worker;

class WoodCutter extends CustomJob
{

    private array $workers;

    public function __construct(private array $data)
    {
        $this->workers = unserialize($this->data["workers"]);
    }

    public function getName(): string
    {
        return "WoodCutter";
    }

    public function getMaxLevels(): int
    {
        return $this->data["max_levels"];
    }

    public function setMaxLevels(int $max_levels): void
    {
        $this->data["max_levels"] = $max_levels;
    }

    public function getMoneyPerLevel(): int
    {
        return $this->data["money_per_level"];
    }

    public function setMoneyPerLevel(int $money_per_level): void
    {
        $this->data["money_per_level"] = $money_per_level;
    }

    /**
     * @return Worker[]
     */
    public function getWorkers(): array
    {
        return $this->workers;
    }

    public function addWorker(Worker $worker): void
    {
        $this->workers[$worker->getName()] = $worker;
    }

    public function getWorker(Player $player): ?Worker
    {
        return $this->workers[$player->getName()] ?? null;
    }

    public function deleteWorker(string $name): void
    {
        unset($this->workers[$name]);
    }

    public function getMenuItem(): Item
    {
        return VanillaBlocks::OAK_LOG()->asItem();
    }

    public function toArray(): array
    {
        return [
            'max_levels' => $this->data["max_levels"],
            'money_per_level' => $this->data["money_per_level"],
            'workers' => serialize($this->workers)
        ];
    }
}