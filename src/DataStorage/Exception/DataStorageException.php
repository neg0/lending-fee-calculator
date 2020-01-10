<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\DataStorage\Exception;

class DataStorageException extends \Exception
{
    public const MESSAGE = "unable to retrieve the data from file";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 400, null);
    }
}
