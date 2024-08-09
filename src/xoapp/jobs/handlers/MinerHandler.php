<?php

namespace xoapp\jobs\handlers;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use xoapp\jobs\factory\JobFactory;

class MinerHandler implements Listener
{

    public function onBlockBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        $block = $event->getBlock();

        $job = JobFactory::getInstance()->getJob("Miner");

        $worker = $job->getWorker($player);

        if (is_null($worker)) {
            return;
        }

        if (!$this->isMineral($block)) {
            return;
        }

        if (
            $worker->getLevel() >= $job->getMaxLevels()
        ) {
            return;
        }

        if (
            $worker->getProgress() >= $worker->getMaxProgress()
        ) {
            $player->sendMessage("§aYou have leveled up in the Miner job!");
            $worker->increaseLevel();
            $worker->resetProgress();
            return;
        }

        $player->sendTip(
            "§eMiner §7| §eProgress: §a" . $worker->getProgress() . " §7| §eLevel: §a" . $worker->getLevel() . "/" . $job->getMaxLevels()
        );

        $worker->increaseProgress();
    }

    private function isMineral(Block $block): bool
    {
        $minerals = [
            BlockTypeIds::DIAMOND_ORE,
            BlockTypeIds::DIAMOND,
            BlockTypeIds::GOLD_ORE,
            BlockTypeIds::GOLD,
            BlockTypeIds::IRON_ORE,
            BlockTypeIds::IRON,
            BlockTypeIds::LAPIS_LAZULI_ORE,
            BlockTypeIds::LAPIS_LAZULI,
            BlockTypeIds::EMERALD_ORE,
            BlockTypeIds::EMERALD,
        ];

        return in_array($block->getTypeId(), $minerals, true);
    }
}