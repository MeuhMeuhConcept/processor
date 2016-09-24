<?php

namespace Mmc\Processor\Component\Tests;

use Mmc\Processor\Component\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $input = new \stdClass();
        $expectedOuput = 'Mmc\Processor\Component\ResponseSample';
        $r = new Request($input, $expectedOuput);

        $this->assertEquals($input, $r->getInput());
        $this->assertEquals($expectedOuput, $r->getExpectedOutput());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadConstruct()
    {
        $input = new \stdClass();
        $badExpectedOutput = new \stdClass();
        $r = new Request($input, $badExpectedOutput);
    }
}
