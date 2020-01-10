<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests\Service;

use Lendable\Interview\Interpolation\Model\LoanInterface;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTerm;
use Lendable\Interview\Interpolation\Model\LoanTerm\LoanTermInterface;
use Lendable\Interview\Interpolation\Service\LoanTerm\Fee\FeeCalculatorService;
use Lendable\Interview\Interpolation\Service\LoanTerm\Fee\LinearInterpolationFeeCalculatorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FeeCalculatorServiceTest extends TestCase
{
    /**
     * @var FeeCalculatorService
     */
    private $sut;

    /**
     * @var LinearInterpolationFeeCalculatorService|MockObject
     */
    private $linearInterpolationFeeCalculatorService;

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

    protected function setUp(): void
    {
        $this->loanTermInterface = $this->createMock(LoanTermInterface::class);
        $this->loanTerm = $this->createMock(LoanTerm::class);
        $this->linearInterpolationFeeCalculatorService = $this->createMock(
            LinearInterpolationFeeCalculatorService::class
        );
        $this->loanInterface = $this->createMock(LoanInterface::class);

        $this->sut = new FeeCalculatorService(
            $this->linearInterpolationFeeCalculatorService
        );
    }

    public function testFeeCalculatorServiceIsInstantiable(): void
    {
        $this->assertInstanceOf(FeeCalculatorService::class, $this->sut);
    }

    public function testCalculatingLoanFeeWhenBreakingPointIsNotMatching(): void
    {
        $this->loanInterface
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTerm);

        $this->loanTerm
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTermInterface);

        $this->loanTermInterface
            ->expects($this->once())
            ->method('isMatchingBreakPoint')
            ->willReturn(true);

        $this->loanTermInterface
            ->expects($this->once())
            ->method('currentFee')
            ->willReturn(115);

        try {
            $this->assertEquals(
                115,
                $this->sut->calculate($this->loanInterface)
            );
        } catch (\Exception $exception) {
            $this->assertEquals(null, $exception);
        }
    }

    public function testCalculatingLoanFeeWhenBreakingPointIsMatching(): void
    {
        $this->loanInterface
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTerm);

        $this->loanTerm
            ->expects($this->once())
            ->method('term')
            ->willReturn($this->loanTermInterface);

        $this->loanTermInterface
            ->expects($this->once())
            ->method('isMatchingBreakPoint')
            ->willReturn(false);

        $this->linearInterpolationFeeCalculatorService
            ->expects($this->once())
            ->method('calculate')
            ->willReturn(115);

        try {
            $this->assertEquals(
                115,
                $this->sut->calculate($this->loanInterface)
            );
        } catch (\Exception $exception) {
            $this->assertEquals(null, $exception);
        }
    }
}
