<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTerm;

interface LoanInterface
{
    public function term(): LoanTerm;

    public function amount(): LoanAmount;
}
