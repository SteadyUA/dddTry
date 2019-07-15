<?php

namespace Numbers\Application;

use Numbers\Application\Persistence\PersistenceManager;
use Numbers\Domain\SumCounterService;
use Throwable;

class MessageProcessor extends AbstractMiddleware
{
    private $manager;
    private $service;
    private $sumCounterId;

    public function __construct(
        PersistenceManager $manager,
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
        if (null === $message) {
            return;
        }

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
