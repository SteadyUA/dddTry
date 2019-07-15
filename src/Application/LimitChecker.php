<?php

namespace Numbers\Application;

use InvalidArgumentException;

class LimitChecker extends AbstractMiddleware
{
    private $limit;

    public function __construct(int $limit)
    {
        $this->setLimit($limit);
    }

    public function execute(Message $message = null): void
    {
        $this->limit --;
        if ($this->limit < 1) {
            exit(0);
        }
    }

    private function setLimit(int $limit): void
    {
        if ($limit < 1) {
            throw new InvalidArgumentException('Invalid limit.');
        }

        $this->limit = $limit;
    }
}
