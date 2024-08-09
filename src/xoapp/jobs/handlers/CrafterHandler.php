<?php

namespace xoapp\jobs\handlers;

use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use xoapp\jobs\factory\JobFactory;

class CrafterHandler implements Listener
{

    public function onCrafting(CraftItemEvent $event): void
    {
        $player = $event->getPlayer();

        $job = JobFactory::getInstance()->getJob("Crafter");

        $worker = $job->getWorker($player);

        if (is_null($worker)) {
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
            $player->sendMessage("§aYou have leveled up in the Crafter job!");
            $worker->increaseLevel();
            $worker->resetProgress();
            return;
        }

        $player->sendTip(
            "§eCrafter §7| §eProgress: §a" . $worker->getProgress() . " §7| §eLevel: §a" . $worker->getLevel() . "/" . $job->getMaxLevels()
        );

        $worker->increaseProgress();
    }
}