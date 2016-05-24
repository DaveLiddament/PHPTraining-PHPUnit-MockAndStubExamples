<?php

namespace Training\PHPUnit\Examples\Test;


use PHPUnit_Framework_MockObject_MockObject;
use Training\PHPUnit\Examples\Calculator;
use Training\PHPUnit\Examples\ItemProcessor;
use Training\PHPUnit\Examples\ListProcessor;

class MockExamplesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $calculator;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $itemProcessor;

    /**
     * @var ListProcessor
     */
    private $listProcessor;


    public function setUp()
    {
        $this->itemProcessor = $this->getMockBuilder(ItemProcessor::class)->getMock();
        $this->listProcessor = new ListProcessor($this->itemProcessor);

        $this->calculator = $this->getMockBuilder(Calculator::class)->getMock();
    }

    
    public function testNeverCalled()
    {
        $this->itemProcessor->expects($this->never())->method("process");
        $this->listProcessor->processList([]);
    }


    public function testCalledOnce()
    {
        $this->itemProcessor->expects($this->once())->method("process");
        $this->listProcessor->processList(['one']);
    }


    public function testCalledOnceCheckInput()
    {
        $this->itemProcessor->expects($this->once())->method("process")->with($this->equalTo("one"));
        $this->listProcessor->processList(['one']);
    }


    public function testCalledMultipleTimes()
    {
        $this->itemProcessor->expects($this->exactly(2))->method("process")->withConsecutive($this->equalTo("one"), $this->equalTo("two"));
        $this->listProcessor->processList(['one', 'two']);
    }


    public function testAnyNumberOfTimes()
    {
        $this->itemProcessor->expects($this->any())->method("process")->withConsecutive($this->equalTo("one"), $this->equalTo("two"));
        $this->listProcessor->processList(['one', 'two']);
    }


    public function testAtLeastOnce()
    {
        $this->itemProcessor->expects($this->atLeast(1))->method("process");
        $this->listProcessor->processList(['one', 'two']);
    }


    public function testAtMostOnce()
    {
        $this->itemProcessor->expects($this->atMost(2))->method("process");
        $this->listProcessor->processList(['one', 'two']);
    }


    public function testMatch1Argument()
    {
        $this->calculator->expects($this->once())->method("calculate")->with(4, $this->anything());
        $this->calculator->calculate(4, 5);
    }

    
    public function testMatchMultipleArgumentsOverMultipleCalls()
    {
        $this->calculator->expects($this->exactly(2))->method("calculate")->withConsecutive([4, $this->anything()], [6, 8]);
        $this->calculator->calculate(4, 5);
        $this->calculator->calculate(6, 8);
    }

}