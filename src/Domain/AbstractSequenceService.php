<?php

namespace Numbers\Domain;

use Generator;

abstract class AbstractSequenceService
{
    /** @var Generator */
    private $generator;
    private $previous;

    public function __construct()
    {
        $this->generator = $this->getGenerator();
    }

    public function getNextNumber(): NumberValue
    {
        if (null != $this->previous) {
            $this->generator->next();
        }
        $current = $this->generator->current();
        $this->previous = $current;

        return $current;
    }

    abstract protected function getGenerator(): Generator;
}
