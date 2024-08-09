<?php

namespace xoapp\jobs\menu;

use pocketmine\player\Player;
use xoapp\jobs\extension\CustomJob;
use xoapp\jobs\factory\JobFactory;
use xoapp\jobs\library\dktapps\pmforms\CustomForm;
use xoapp\jobs\library\dktapps\pmforms\CustomFormResponse;
use xoapp\jobs\library\dktapps\pmforms\element\Input;

class FormsManager
{

    public static function editJob(string $key): CustomForm
    {

        $job = JobFactory::getInstance()->getJob($key);

        return new CustomForm(
            "Edit " . $job->getName() . " Job",
            [
                new Input(
                    "max_levels", "Max Levels", "Example: 6", $job->getMaxLevels()
                ),
                new Input(
                    "money_per_level", "Money Per Level", "Example: 1000", $job->getMoneyPerLevel()
                )
            ],
            function (Player $player, CustomFormResponse $response) use ($job): void {

                $max_levels = $response->getString("max_levels");
                $money_per_level = $response->getString("money_per_level");

                if (!is_numeric($max_levels)) {
                    $player->sendMessage("§cThe max levels value must be a number");
                    return;
                }

                if (!is_numeric($money_per_level)) {
                    $player->sendMessage("§cThe money per level value must be a number");
                    return;
                }

                $job->setMaxLevels($max_levels);
                $job->setMoneyPerLevel($money_per_level);

                $player->sendMessage("§aJob Info Modified");
            }
        );
    }
}