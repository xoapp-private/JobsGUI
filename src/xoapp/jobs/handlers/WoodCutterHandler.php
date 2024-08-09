<?php

namespace xoapp\jobs\handlers;

use pocketmine\block\Wood;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use xoapp\jobs\factory\JobFactory;

class WoodCutterHandler implements Listener
{

    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        $block = $event->getBlock();

        $job = JobFactory::getInstance()->getJob("WoodCutter");

        $worker = $job->getWorker($player);

        if (is_null($worker)) {
            return;
        }

        if (!$block instanceof Wood) {
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
            $player->sendMessage("§aYou have leveled up in the WoodCutter job!");
            $worker->increaseLevel();
            $worker->resetProgress();
            return;
        }

        $player->sendTip(
            "§eWoodCutter §7| §eProgress: §a" . $worker->getProgress() . " §7| §eLevel: §a" . $worker->getLevel() . "/" . $job->getMaxLevels()
        );

        $worker->increaseProgress();
    }
}