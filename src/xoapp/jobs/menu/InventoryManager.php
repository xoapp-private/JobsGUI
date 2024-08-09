<?php

namespace xoapp\jobs\menu;

use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use xoapp\jobs\extension\Worker;
use xoapp\jobs\factory\JobFactory;
use xoapp\jobs\library\muqsit\invmenu\InvMenu;
use xoapp\jobs\library\muqsit\invmenu\transaction\InvMenuTransaction;
use xoapp\jobs\library\muqsit\invmenu\transaction\InvMenuTransactionResult;
use xoapp\jobs\library\muqsit\invmenu\type\InvMenuTypeIds;

class InventoryManager
{

    public static function selectJob(Player $player): void
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);

        $menu->setName("Job Selector");

        $inventory = $menu->getInventory();

        $extra = VanillaBlocks::STAINED_GLASS()
            ->setColor(DyeColor::GREEN)
            ->asItem();
        $extra->setNamedTag(
            CompoundTag::create()->setString("job", "extra")
        );
        $extra->setCustomName(" ");

        for ($i = 0; $i >= $inventory->getSize(); $i++) {

            if (in_array($i, [10, 12, 14, 16])) {
                continue;
            }

            $inventory->setItem($i, $extra);
        }

        $jobs = JobFactory::getInstance()->getJobs();

        foreach ($jobs as $job) {

            $item = $job->getMenuItem();

            $item->setNamedTag(
                CompoundTag::create()->setString("job", $job->getName())
            );

            $item->setCustomName("§e" . $job->getName());

            $item->setLore(
                array_map(
                    fn (string $line) => TextFormat::colorize($line),
                    [
                        " ",
                        "&fMax Levels: " . $job->getMaxLevels(),
                        " ",
                        "&fWorkers: &6" . sizeof($job->getWorkers()),
                        " ",
                        "&aClick to join"
                    ]
                )
            );

            $inventory->addItem($item);
        }

        $menu->setListener(
            function (InvMenuTransaction $transaction): InvMenuTransactionResult {
                $player = $transaction->getPlayer();

                $item = $transaction->getItemClicked();

                $nbt = $item->getNamedTag()->getTag("job");

                if (is_null($nbt)) {
                    return $transaction->discard();
                }

                $key = $nbt->getValue();

                if ($key === "extra") {
                    return $transaction->discard();
                }

                $job = JobFactory::getInstance()->getJob($key);

                if (is_null($job)) {
                    return $transaction->discard();
                }

                $worker = $job->getWorker($player);

                if (!is_null($worker)) {
                    $player->sendMessage("§eYou already working on this job");
                    return $transaction->discard();
                }

                $job->addWorker(
                    new Worker($player, 0, 0)
                );

                $player->sendMessage("§aYou joined to work in " . $job->getName() . " Job");

                return $transaction->discard();
            }
        );

        $menu->send($player);
    }

    public static function viewProgress(Player $player): void
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);

        $menu->setName("Job Progress");

        // TODO: Toda esta madre alaverga
    }
}