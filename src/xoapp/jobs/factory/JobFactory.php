<?php

namespace xoapp\jobs\factory;

use pocketmine\utils\SingletonTrait;
use xoapp\jobs\data\DataManager;
use xoapp\jobs\extension\CustomJob;
use xoapp\jobs\extension\types\Crafter;
use xoapp\jobs\extension\types\MinerJob;
use xoapp\jobs\extension\types\WoodCutter;

class JobFactory
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    /** @var CustomJob[] */
    private array $jobs = [];

    public function initialize(): void
    {
        $saved = DataManager::getInstance()->getSavedData();

        foreach ($saved as $key => $data) {
            $this->jobs[$key] = $this->getJobClass($key, $data);
        }
    }

    public function save(): void
    {
        foreach ($this->jobs as $job) {
            DataManager::getInstance()->setData(
                $job->getName(), $job->toArray()
            );
        }
    }

    public function getJob(string $key): ?CustomJob
    {
        return $this->jobs[$key] ?? null;
    }

    /**
     * @return CustomJob[]
     */
    public function getJobs(): array
    {
        return $this->jobs;
    }

    private function getJobClass(string $name, array $data): CustomJob
    {
        return match ($name) {
            "Miner" => new MinerJob($data),
            "Crafter" => new Crafter($data),
            "WoodCutter" => new WoodCutter($data)
        };
    }
}