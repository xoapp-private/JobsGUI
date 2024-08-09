<?php

namespace xoapp\jobs\data;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use xoapp\jobs\Loader;

class DataManager
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private Config $data;

    public function __construct()
    {
        self::setInstance($this);

        $this->data = new Config(
            Loader::getInstance()->getDataFolder() . "data.json", Config::JSON
        );
    }

    public function setData(string $key, mixed $data): void
    {
        $this->data->set($key, $data);
        $this->data->save();
    }

    public function getData(string $key): mixed
    {
        return $this->data->get($key);
    }

    public function getSavedData(): array
    {
        return $this->data->getAll(true);
    }
}