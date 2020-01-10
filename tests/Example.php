<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Service\LoanTerm\Fee\FeeCalculatorService;
use PHPUnit\Framework\TestCase;

class Example extends TestCase
{
    public function testExample(): void
    {
        $loanApp = LoanApplication::create(24, 2750);
        $calculator = FeeCalculatorService::create();

        $fee = $calculator->calculate($loanApp);

        $this->assertEquals(115.0, (float) $fee);
        $this->assertEquals(115, $fee);
        $this->assertEquals('double', getType($fee));
    }
}
