<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm;

use Lendable\Interview\Interpolation\Model\Exception\InvalidLoanAmountException;
use Lendable\Interview\Interpolation\Model\LoanAmount;
use Lendable\Interview\Interpolation\Model\LoanTerm\Exception\InvalidLoanTermException;
use Lendable\Interview\Interpolation\Repository\LoanTerm\Fee\LoanTermFeeRepository;
use Lendable\Interview\Interpolation\Repository\RepositoryInterface;

class LoanTerm
{
    /**
     * @var LoanTermInterface
     */
    private $strategy;

    /**
     * @throws InvalidLoanAmountException
     */
    public function __construct(int $duration, float $amount, RepositoryInterface $repository)
    {
        $amount = new LoanAmount($amount);
        $supportedLoanTerms = [
            new LoanTerm12Months($amount, $repository),
            new LoanTerm24Months($amount, $repository),
        ];

        /** @var LoanTermInterface $term */
        foreach ($supportedLoanTerms as $term) {
            if (null !== $term && $term->term() === $duration) {
                $this->strategy = $term;
            }
        }

        if (null === $this->strategy) {
            throw new InvalidLoanTermException();
        }
    }

    /**
     * @throws InvalidLoanAmountException
     */
    public static function create(int $duration, float $amount): self
    {
        return new self($duration, $amount, LoanTermFeeRepository::create());
    }

    public function term(): LoanTermInterface
    {
        return $this->strategy;
    }
}
