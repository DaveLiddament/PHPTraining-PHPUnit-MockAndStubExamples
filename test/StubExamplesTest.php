<?php

namespace Training\PHPUnit\Examples\Test;


use PHPUnit_Framework_MockObject_MockObject;
use Training\PHPUnit\Examples\Calculator;

class StubExamplesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $calculator;


    public function setUp()
    {
        $this->calculator = $this->getMockBuilder(Calculator::class)->getMock();
    }


    public function testReturnSameAnswerEveryTime()
    {
        $this->calculator->method("calculate")->willReturn(7);

        $this->assertEquals(7, $this->calculator->calculate(1, 2));
        $this->assertEquals(7, $this->calculator->calculate(3, 4));
        $this->assertEquals(7, $this->calculator->calculate(6, 7));
    }


    public function testReturnDifferencAnswerEachTime()
    {
        $this->calculator->method("calculate")->willReturnOnConsecutiveCalls(3, 5, 4);

        $this->assertEquals(3, $this->calculator->calculate(1, 2));
        $this->assertEquals(5, $this->calculator->calculate(3, 4));
        $this->assertEquals(4, $this->calculator->calculate(6, 7));

        // After all return values have iterated through null is returned
        $this->assertEquals(null, $this->calculator->calculate(4, 7));
    }


    public function testReturnFirstArgument()
    {
        $this->calculator->method("calculate")->willReturnArgument(0);
        $this->assertEquals(1, $this->calculator->calculate(1, 2));
        $this->assertEquals(3, $this->calculator->calculate(3, 4));
    }


    public function testReturnSecondArgument()
    {
        $this->calculator->method("calculate")->willReturnArgument(1);
        $this->assertEquals(2, $this->calculator->calculate(1, 2));
        $this->assertEquals(4, $this->calculator->calculate(3, 4));
    }


    public function testReturnCallback()
    {
        $this->calculator->method("calculate")->willReturnCallback(
            function ($a, $b) {
                return $a + $b;
            }
        );
        $this->assertEquals(3, $this->calculator->calculate(1, 2));
        $this->assertEquals(7, $this->calculator->calculate(3, 4));
    }


    public function testReturnMap()
    {
        $mapping = [
            [1, 2, 8],
            [3, 4, 5],
        ];

        $this->calculator->method("calculate")->willReturnMap($mapping);
        $this->assertEquals(8, $this->calculator->calculate(1, 2));
        $this->assertEquals(5, $this->calculator->calculate(3, 4));

        // Unspecified mapping returns null
        $this->assertEquals(null, $this->calculator->calculate(3, 8));
    }


    public function testReturnSelf()
    {
        $this->calculator->method("calculate")->willReturnSelf();
        $this->assertEquals($this->calculator, $this->calculator->calculate(6, 8));
    }

    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 20
     * @expectedExceptionMessage A message
     */
    public function testThrowException()
    {
        $this->calculator->method("calculate")->willThrowException(new \InvalidArgumentException("A message", 20));
        $this->calculator->calculate(6, 8);
    }

}