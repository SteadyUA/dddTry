<?php

namespace Numbers\Application;

use InvalidArgumentException;

class LimitChecker
{
    private $limit;

    public function __construct(int $limit = null)
    {
        $this->setLimit($limit);
    }

    public function isLimitReached(): bool
    {
        if (null == $this->limit) {
            return false;
        }
        $this->limit --;

        return $this->limit < 1;
    }

    private function setLimit(int $limit = null): void
    {
        if (null !== $limit && $limit < 1) {
            throw new InvalidArgumentException('Invalid limit.');
        }

        $this->limit = $limit;
    }
}
