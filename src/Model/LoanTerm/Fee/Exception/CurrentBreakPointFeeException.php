<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model\LoanTerm\Fee\Exception;

class CurrentBreakPointFeeException extends \Exception
{
    public const MESSAGE = "couldn't find current breakpoint's fee";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 400, null);
    }
}
