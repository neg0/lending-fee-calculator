<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service\LoanTerm\Fee;

use Lendable\Interview\Interpolation\Model\LoanInterface;

class FeeCalculatorService implements FeeCalculatorInterface
{
    /**
     * @var LinearInterpolationFeeCalculatorService
     */
    private $linearInterpolationFeeCalculatorService;

    public function __construct(
        LinearInterpolationFeeCalculatorService $linearInterpolationFeeCalculatorService
    ) {
        $this->linearInterpolationFeeCalculatorService = $linearInterpolationFeeCalculatorService;
    }

    public static function create(): self
    {
        return new self(new LinearInterpolationFeeCalculatorService());
    }

    public function calculate(LoanInterface $loanApplication): float
    {
        $loanTerm = $loanApplication->term()->term();
        if ($loanTerm->isMatchingBreakPoint()) {
            return $loanTerm->currentFee();
        }

        return $this->linearInterpolationFeeCalculatorService->calculate($loanApplication);
    }
}
