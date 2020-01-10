<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\DataStorage;

use Lendable\Interview\Interpolation\DataStorage\Exception\DataStorageException;

class DataStorage implements DataStorageInterface
{
    /**
     * @var string
     */
    private $dataSource;

    /**
     * @var ?DataStorage
     */
    private static $instance;

    public static function instance(): DataStorage
    {
        if (null === self::$instance) {
            return self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @throws DataStorageException
     */
    private function __construct()
    {
        $jsonDataStoreFileName = getenv('STORAGE_FILE') ? getenv('STORAGE_FILE') : 'fee-table.json';
        $this->dataSource = file_get_contents(__DIR__ . "/" . $jsonDataStoreFileName);
        if (false === $this->dataSource) {
            throw new DataStorageException();
        }

        $this->dataSource = \json_decode($this->dataSource, true);
    }

    public function getDataSource(): array
    {
        return $this->dataSource;
    }
}
