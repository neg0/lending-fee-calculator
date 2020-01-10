<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests\Service\LoanTerm\Fee;

use Lendable\Interview\Interpolation\Model\LoanAmount;
use Lendable\Interview\Interpolation\Model\LoanInterface;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTerm;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTermInterface;
use Lendable\Interview\Interpolation\Service\LoanTerm\Fee\LinearInterpolationFeeCalculatorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LinearInterpolationFeeCalculatorServiceTest extends TestCase
{
    /**
     * @var LinearInterpolationFeeCalculatorService
     */
    private $sut;

    /**
     * @var LoanInterface|MockObject
     */
    private $loanInterface;

    /**
     * @var LoanTerm|MockObject
     */
    private $loanTerm;

    /**
     * @var LoanTermInterface|MockObject
     */
    private $loanTermInterface;

    /**
     * @var LoanAmount|MockObject
     */
    private $loanAmount;

    protected function setUp(): void
    {
        $this->loanTermInterface = $this->createMock(LoanTermInterface::class);
        $this->loanTerm = $this->createMock(LoanTerm::class);
        $this->loanAmount = $this->createMock(LoanAmount::class);

        $this->loanInterface = $this->createMock(LoanInterface::class);

        $this->sut = new LinearInterpolationFeeCalculatorService();
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(LinearInterpolationFeeCalculatorService::class, $this->sut);
    }

    public function testCalculateWithAcceptanceCriteria(): void
    {
        $this->loanInterface
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTerm);

        $this->loanTerm
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTermInterface);

        $this->loanInterface
            ->expects($this->once())
            ->method('amount')
            ->willReturn($this->loanAmount);

        $this->loanAmount
            ->expects($this->once())
            ->method('amount')
            ->willReturn(2750);

        $this->loanTermInterface
            ->expects($this->exactly(2))
            ->method('currentBreakPoint')
            ->willReturn(2000);

        $this->loanTermInterface
            ->expects($this->once())
            ->method('nextFee')
            ->willReturn(120);

        $this->loanTermInterface
            ->expects($this->exactly(2))
            ->method('currentFee')
            ->willReturn(100);

        $this->loanTermInterface
            ->expects($this->once())
            ->method('nextBreakPoint')
            ->willReturn(3000);

        try {
            $actual = $this->sut->calculate($this->loanInterface);

            $this->assertEquals(115, $actual);
        } catch (\Exception $exception) {
            $this->assertNull($exception);
        }
    }
}
