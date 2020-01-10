<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Repository\LoanTerm\Fee;

use Lendable\Interview\Interpolation\DataStorage\DataStorage;
use Lendable\Interview\Interpolation\DataStorage\DataStorageInterface;
use Lendable\Interview\Interpolation\Entity\FeeStructureEntity;
use Lendable\Interview\Interpolation\Repository\RepositoryInterface;

class LoanTermFeeRepository implements RepositoryInterface
{
    /**
     * @var DataStorageInterface
     */
    private $dataStorage;

    public function __construct(DataStorageInterface $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    public static function create(): self
    {
        return new LoanTermFeeRepository(DataStorage::instance());
    }

    /**
     * @return FeeStructureEntity[]|null
     */
    public function findOne(int $termId): ?array
    {
        $feeStructureEntities = [];
        foreach ($this->dataStorage->getDataSource() as $dataSource) {
            if ($dataSource['term'] === $termId) {
                foreach ($dataSource['table'] as $row) {
                    array_push(
                        $feeStructureEntities,
                        new FeeStructureEntity($row['threshold'], $row['fee'])
                    );
                }

                return $feeStructureEntities;
            }
        }

        return null;
    }
}
