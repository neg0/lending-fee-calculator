<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests\Repository\LoanTerm\Fee;

use Lendable\Interview\Interpolation\DataStorage\DataStorage;
use Lendable\Interview\Interpolation\Repository\LoanTerm\Fee\LoanTermFeeRepository;
use PHPUnit\Framework\TestCase;

class LoanTermFeeRepositoryTest extends TestCase
{
    /**
     * @var LoanTermFeeRepository
     */
    private $sut;

    protected function setUp(): void
    {
        $this->sut = new LoanTermFeeRepository(DataStorage::instance());
    }

    public function testLoanTermFeeRepositoryShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(LoanTermFeeRepository::class, $this->sut);
    }

    public function testToFetchArrayOfFeeStructureFor12MonthsLoan(): void
    {
        $this->assertCount(20, $this->sut->findOne(12));
    }

    public function testToFetchArrayOfFeeStructureFor24MonthsLoan(): void
    {
        $this->assertCount(20, $this->sut->findOne(24));
    }
}
