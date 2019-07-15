<?php

namespace Numbers\Domain;

use Generator;

class FibonacciSequenceService extends AbstractSequenceService
{
    protected function getGenerator(): Generator
    {
        $current = new NumberValue('0');
        $previous = null;
        while (true) {
            yield $current;
            if (null == $previous) {
                $nextNumber = new NumberValue('1');
            } else {
                $nextNumber = $current->add($previous);
            }
            $previous = $current;
            $current = $nextNumber;
        }
    }
}
