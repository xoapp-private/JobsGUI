<?php

namespace xoapp\jobs\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use xoapp\jobs\factory\JobFactory;
use xoapp\jobs\menu\FormsManager;
use xoapp\jobs\menu\InventoryManager;

class JobCommand extends Command
{

    public function __construct()
    {
        parent::__construct("job");

        $this->setPermission("job.command");

        $this->setAliases(
            ["jobs"]
        );
    }

    public function execute(CommandSender $player, string $commandLabel, array $args): void
    {
        if (!$player instanceof Player) {
            return;
        }

        if (!$this->testPermissionSilent($player)) {
            return;
        }

        if (isset($args[0])) {
            if ($args[0] === "edit") {
                if (!$player->hasPermission("job.command.edit")) {
                    InventoryManager::selectJob($player);
                    return;
                }

                if (!isset($args[1])) {
                    $player->sendMessage("Usage /job edit (job)");
                    return;
                }

                $job = JobFactory::getInstance()->getJob($args[1]);

                if (is_null($job)) {
                    $player->sendMessage("This job not exist");
                    return;
                }

                $player->sendForm(FormsManager::editJob($args[1]));
                return;
            }
        }
    }
}