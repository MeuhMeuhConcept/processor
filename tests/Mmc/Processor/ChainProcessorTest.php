<?php

namespace Mmc\Processor\Test;

use Mmc\Processor\BasicProcessor;
use Mmc\Processor\ChainProcessor;
use Mmc\Processor\Request;
use Mmc\Processor\ResponseStatusCode;

class ChainProcessorTest extends \PHPUnit_Framework_TestCase
{
    private $chainProcessor;

    public function setup()
    {
        $this->chainProcessor = new ChainProcessor();

        $this->chainProcessor
            ->add(
                new BasicProcessor('foo', null, 'bar'),
                'p1',
                5
            )
            ->add(
                new BasicProcessor('foo', null, 'bar'),
                'p2',
                3
            )
            ->add(
                new BasicProcessor('bar', null, 'foo'),
                'p3',
                1
            )
        ;
    }

    public function testNotImplement()
    {
        $request = new Request('foobar');

        $this->assertFalse($this->chainProcessor->supports($request));

        $this->assertEquals(ResponseStatusCode::NOT_IMPLEMENTED, $this->chainProcessor->process($request)->getStatusCode());
    }

    public function testChain()
    {
        $request = new Request('foo');

        $this->assertTrue($this->chainProcessor->supports($request));
        $response = $this->chainProcessor->process($request);
        $this->assertEquals('bar', $response->getOutput());
        $this->assertEquals('p2', $response->getExtra('name'));
    }
}
