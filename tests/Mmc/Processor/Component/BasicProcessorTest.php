<?php

namespace Mmc\Processor\Component\Test;

use Mmc\Processor\Component\BasicProcessor;
use Mmc\Processor\Component\ResponseStatusCode;

class BasicProcessorTest extends \PHPUnit_Framework_TestCase
{
    private $processor;

    public function setup()
    {
        $this->processor = new BasicProcessor('foo', 'bar');
    }

    public function testUnsupported()
    {
        $request = 'bar';

        $this->assertFalse($this->processor->supports($request));

        $this->assertEquals(ResponseStatusCode::NOT_SUPPORTED, $this->processor->process($request)->getStatusCode());
    }

    public function testProcess()
    {
        $request = 'foo';

        $this->assertTrue($this->processor->supports($request));

        $response = $this->processor->process($request);

        $this->assertEquals($request, $response->getRequest());
        $this->assertEquals(ResponseStatusCode::OK, $response->getStatusCode());
        $this->assertEquals('bar', $response->getOutput());
    }
}
