<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\Model\Exception\InvalidLoanAmountException;

class LoanAmount
{
    public const MAX_ACCEPTED_AMOUNT = 20000.0;
    public const MIN_ACCEPTED_AMOUNT = 1000.0;

    /**
     * @var float
     */
    private $amount;

    /**
     * @throws InvalidLoanAmountException
     */
    public function __construct(float $amount)
    {
        if ($amount > self::MAX_ACCEPTED_AMOUNT || $amount < self::MIN_ACCEPTED_AMOUNT) {
            throw new InvalidLoanAmountException();
        }

        $this->amount = $amount;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
