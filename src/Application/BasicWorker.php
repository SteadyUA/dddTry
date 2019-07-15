<?php

namespace Numbers\Application;

use InvalidArgumentException;

class BasicWorker
{
    private $sleepTime;
    private $task;

    public function __construct(AbstractMiddleware $task, int $sleepTime = 0)
    {
        $this->setSleepTime($sleepTime);
        $this->task = $task;
    }

    public function run(): void
    {
        while (true) {
            $this->task->execute(null);
            usleep($this->sleepTime);
        };
    }

    private function setSleepTime(int $sleepTime): void
    {
        if ($sleepTime < 0) {
            throw new InvalidArgumentException('Sleep time negative.');
        }
        $this->sleepTime = $sleepTime;
    }
}
