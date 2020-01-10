<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm;

interface LoanTermInterface
{
    public function isMatchingBreakPoint(): bool;
    public function currentBreakPoint(): ?int;
    public function nextBreakPoint(): int;
    public function currentFee(): int;
    public function nextFee(): float;
    public function term(): int;
}
