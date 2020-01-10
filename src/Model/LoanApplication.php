<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\Model\Exception\InvalidLoanAmountException;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTerm;

final class LoanApplication implements LoanInterface
{
    /**
     * @var LoanTerm
     */
    private $term;

    /**
     * @var LoanAmount
     */
    private $amount;

    private function __construct(LoanTerm $term, LoanAmount $amount)
    {
        $this->term = $term;
        $this->amount = $amount;
    }

    /**
     * @throws InvalidLoanAmountException
     */
    public static function create(int $term, float $amount): self
    {
        return new self(
            LoanTerm::create($term, $amount),
            new LoanAmount($amount)
        );
    }

    public function term(): LoanTerm
    {
        return $this->term;
    }

    public function amount(): LoanAmount
    {
        return $this->amount;
    }
}
