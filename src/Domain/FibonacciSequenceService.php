<?php

namespace Numbers\Domain;

use Generator;

class FibonacciSequenceService extends AbstractSequenceService
{
    protected function getGenerator(): Generator
    {
        $previous = new NumberValue('0');
        yield $previous;
        $next = new NumberValue('1');
        while (true) {
            $next = $next->add($previous);
            yield $next;
            $previous = $next;
        }
    }
}
