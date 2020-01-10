<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests\Model\LoanTerm;

use Lendable\Interview\Interpolation\Entity\FeeStructureEntity;
use Lendable\Interview\Interpolation\Model\Exception\InvalidLoanAmountException;
use Lendable\Interview\Interpolation\Model\LoanTerm\Exception\InvalidLoanTermException;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTerm;
use Lendable\Interview\Interpolation\Repository\RepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LoanTermTest extends TestCase
{
    /**
     * @var RepositoryInterface|MockObject
     */
    private $repositoryInterface;

    protected function setUp(): void
    {
        $this->repositoryInterface = $this->createMock(RepositoryInterface::class);
    }

    public function testLoanTermCreationFor12Months(): void
    {
        $this->repositoryInterface
            ->expects($this->exactly(3))
            ->method('findOne')
            ->willReturn([
                new FeeStructureEntity(2000, 90),
                new FeeStructureEntity(3000, 90),
            ]);

        try {
            $actual = new LoanTerm(12, 2750, $this->repositoryInterface);

            $this->assertEquals(12, $actual->term()->term());
            $this->assertEquals(2000, $actual->term()->currentBreakPoint());
            $this->assertEquals(90, $actual->term()->currentFee());
            $this->assertEquals(3000, $actual->term()->nextBreakPoint());
            $this->assertEquals(90, $actual->term()->nextFee());
            $this->assertFalse($actual->term()->isMatchingBreakPoint());
        } catch (\Exception $exception) {
            $this->assertNull($exception);
        }
    }

    public function testLoanTermCreationFor24Months(): void
    {
        $this->repositoryInterface
            ->expects($this->exactly(3))
            ->method('findOne')
            ->willReturn([
                new FeeStructureEntity(2000, 100),
                new FeeStructureEntity(3000, 120),
            ]);

        try {
            $actual = new LoanTerm(12, 2750, $this->repositoryInterface);

            $this->assertEquals(12, $actual->term()->term());
            $this->assertEquals(2000, $actual->term()->currentBreakPoint());
            $this->assertEquals(100, $actual->term()->currentFee());
            $this->assertEquals(3000, $actual->term()->nextBreakPoint());
            $this->assertEquals(120, $actual->term()->nextFee());
            $this->assertFalse($actual->term()->isMatchingBreakPoint());
        } catch (\Exception $exception) {
            $this->assertNull($exception);
        }
    }

    public function testShouldFailCreatingLoanTermDueToInvalidTermDuration(): void
    {
        try {
            new LoanTerm(25, 2000, $this->repositoryInterface);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidLoanTermException::class, $exception);
        }
    }

    public function testShouldFailCreatingLoanTermDueToInvalidAmount(): void
    {
        try {
            new LoanTerm(24, 25000, $this->repositoryInterface);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidLoanAmountException::class, $exception);
        }
    }
}
