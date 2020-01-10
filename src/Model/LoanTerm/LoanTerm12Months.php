<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm;

use Lendable\Interview\Interpolation\Model\LoanAmount;
use Lendable\Interview\Interpolation\Model\LoanTerm\Fee\AbstractLoanTermFee;
use Lendable\Interview\Interpolation\Repository\RepositoryInterface;

class LoanTerm12Months extends AbstractLoanTermFee implements LoanTermInterface
{
    public const DURATION = 12;

    public function __construct(LoanAmount $amount, RepositoryInterface $repository)
    {
        parent::__construct($amount, $repository, self::DURATION);
    }

    public function term(): int
    {
        return self::DURATION;
    }
}
