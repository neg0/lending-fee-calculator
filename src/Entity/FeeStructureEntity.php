<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Entity;

class FeeStructureEntity
{
    public const FIELD_THRESHOLD = 'threshold';
    public const FIELD_FEE = 'fee';

    /**
     * @var int
     */
    private $threshold;

    /**
     * @var int
     */
    private $fee;

    public function __construct(int $threshold, int $fee)
    {
        $this->threshold = $threshold;
        $this->fee = $fee;
    }

    public function getThreshold(): int
    {
        return $this->threshold;
    }

    public function getFee(): int
    {
        return $this->fee;
    }
}
