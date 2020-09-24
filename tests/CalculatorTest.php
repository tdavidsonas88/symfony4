<?php

namespace App\Tests;

use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testCalculator()
    {
        $calculator = new Calculator();
        $result = $calculator->add(1, 9);
        $this->assertEquals(10, $result);
    }

}
