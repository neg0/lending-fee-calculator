<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\DataStorage;

interface DataStorageInterface
{
    public function getDataSource(): array;
}
