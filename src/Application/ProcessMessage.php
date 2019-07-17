<?php

namespace Numbers\Application;

use Numbers\Infrastructure\MessageBus\Message;
use Numbers\Infrastructure\Persistence\TransactionManager;
use Throwable;

class ProcessMessage extends AbstractMiddleware
{
    private $manager;
    private $service;
    private $sumCounterId;

    public function __construct(
        TransactionManager $manager,
        SumCounterService $service,
        string $sumCounterId
    ) {
        $this->manager = $manager;
        $this->service = $service;
        $this->sumCounterId = $sumCounterId;
    }

    /**
     * @param Message|null $message
     * @throws Throwable
     */
    public function execute(Message $message = null): void
    {
        $this->manager->beginTransaction();
        try {
            $this->service->addNumber($this->sumCounterId, $message->number());
            $this->manager->commitTransaction();
        } catch (Throwable $ex) {
            $this->manager->rollbackTransaction();
            throw $ex;
        }
        $this->executeNext($message);
    }
}
