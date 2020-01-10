<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm\Exception;

class InvalidLoanTermException extends \InvalidArgumentException
{
    public const MESSAGE = "term duration is invalid";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 400, null);
    }
}
