<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm\Fee;

use Lendable\Interview\Interpolation\Entity\FeeStructureEntity;
use Lendable\Interview\Interpolation\Model\LoanAmount;
use Lendable\Interview\Interpolation\Model\LoanTerm\Fee\Exception\CurrentBreakPointFeeException;
use Lendable\Interview\Interpolation\Model\LoanTerm\Fee\Exception\NextBreakPointFeeException;
use Lendable\Interview\Interpolation\Repository\RepositoryInterface;

abstract class AbstractLoanTermFee
{
    private const DEFAULT_BREAKPOINT = 1000;

    /**
     * @var LoanAmount
     */
    protected $amount;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var int
     */
    protected $duration;

    protected function __construct(LoanAmount $amount, RepositoryInterface $repository, int $duration)
    {
        $this->amount = $amount;
        $this->repository = $repository;
        $this->duration = $duration;
    }

    public function currentBreakPoint(): int
    {
        return (int) floor($this->amount->amount() / self::DEFAULT_BREAKPOINT) * self::DEFAULT_BREAKPOINT;
    }

    public function nextBreakPoint(): int
    {
        $next = (int) ceil($this->amount->amount() / self::DEFAULT_BREAKPOINT) * self::DEFAULT_BREAKPOINT;

        if ($next > LoanAmount::MAX_ACCEPTED_AMOUNT) {
            return $next - self::DEFAULT_BREAKPOINT;
        }

        if ($next - self::DEFAULT_BREAKPOINT <  LoanAmount::MIN_ACCEPTED_AMOUNT) {
            return $next + self::DEFAULT_BREAKPOINT;
        }

        return $next;
    }

    public function isMatchingBreakPoint(): bool
    {
        foreach ($this->feeStructure() as $structure) {
            if ($structure->getThreshold() === $this->amount->amount()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws CurrentBreakPointFeeException
     */
    public function currentFee(): int
    {
        foreach ($this->feeStructure() as $structure) {
            if ($structure->getThreshold() === $this->currentBreakPoint()) {
                return $structure->getFee();
            }
        }

        throw new CurrentBreakPointFeeException();
    }

    /**
     * @throws NextBreakPointFeeException
     */
    public function nextFee(): float
    {
        foreach ($this->feeStructure() as $structure) {
            if ($structure->getThreshold() === $this->nextBreakPoint()) {
                return $structure->getFee();
            }
        }

        throw new NextBreakPointFeeException();
    }

    /**
     * @return FeeStructureEntity[]|null
     */
    private function feeStructure(): array
    {
        return $this->repository->findOne($this->duration);
    }
}
