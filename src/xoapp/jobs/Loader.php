<?php

namespace xoapp\jobs;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use xoapp\jobs\factory\JobFactory;
use xoapp\jobs\handlers\CrafterHandler;
use xoapp\jobs\handlers\MinerHandler;
use xoapp\jobs\handlers\WoodCutterHandler;

class Loader extends PluginBase
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    protected function onEnable(): void
    {
        self::setInstance($this);

        $this->loadHandlers();

        JobFactory::getInstance()->initialize();
    }

    private function loadHandlers(): void
    {
        $manager = $this->getServer()->getPluginManager();

        $manager->registerEvents(new CrafterHandler(), $this);
        $manager->registerEvents(new MinerHandler(), $this);
        $manager->registerEvents(new WoodCutterHandler(), $this);
    }

    protected function onDisable(): void
    {
        JobFactory::getInstance()->save();
    }
}