<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service\LoanTerm\Fee;

use Lendable\Interview\Interpolation\Model\LoanInterface;

interface FeeCalculatorInterface
{
    public function calculate(LoanInterface $loanApplication): float;
}
