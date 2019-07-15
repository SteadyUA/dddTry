<?php

namespace Numbers\Application;

/**
 * Based on Chain of responsibility pattern
 */
abstract class AbstractMiddleware
{
    /** @var AbstractMiddleware|null */
    private $next;

    public function setNext(AbstractMiddleware $next): AbstractMiddleware
    {
        $this->next = $next;

        return $next;
    }

    public function executeNext(Message $message): void
    {
        if (null !== $this->next) {
            $this->next->execute($message);
        }
    }

    abstract public function execute(Message $message = null): void;
}
