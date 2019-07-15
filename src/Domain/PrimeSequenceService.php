<?php

namespace Numbers\Domain;

use Generator;

class PrimeSequenceService extends AbstractSequenceService
{
    protected function getGenerator(): Generator
    {
        yield new NumberValue('2');
        yield new NumberValue('3');
        $num = 3;
        while (true) {
            $num += 2;
            $prime = true;
            $to = ceil(sqrt($num)) + 1;
            for ($n = 3; $n < $to; $n += 2) {
                if ($num % $n == 0) {
                    $prime = false;
                    break;
                }
            }
            if ($prime) {
                yield new NumberValue($num);
            }
        }
    }
}
