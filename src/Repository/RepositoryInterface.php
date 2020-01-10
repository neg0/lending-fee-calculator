<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Repository;

interface RepositoryInterface
{
    public function findOne(int $id): ?array;
}
