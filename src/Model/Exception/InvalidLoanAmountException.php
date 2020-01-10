<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\Exception;

class InvalidLoanAmountException extends \Exception
{
    public const MESSAGE = "loans amount should be between 1000 & 20,000";

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
