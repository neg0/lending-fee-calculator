<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service\LoanTerm\Fee;

use Lendable\Interview\Interpolation\Model\LoanInterface;

class LinearInterpolationFeeCalculatorService implements FeeCalculatorInterface
{
    public function calculate(LoanInterface $loanApplication): float
    {
        $loanTerm = $loanApplication->term()->term();
        $amount = $loanApplication->amount()->amount();

        $subtractedAmount = $amount - $loanTerm->currentBreakPoint();
        $subtractedFee = $loanTerm->nextFee() - $loanTerm->currentFee();
        $subtractedThreshold = $loanTerm->nextBreakPoint() - $loanTerm->currentBreakPoint();

        $fee = (($subtractedAmount * $subtractedFee) / $subtractedThreshold) + $loanTerm->currentFee();

        $reminder = fmod(($amount + $fee), 5);
        if ($reminder) {
            return round((5 - $reminder) + $fee, 2);
        }

        return $fee;
    }
}
