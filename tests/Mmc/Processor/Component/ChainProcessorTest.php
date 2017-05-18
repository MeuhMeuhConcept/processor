<?php

namespace Mmc\Processor\Component\Test;

use Mmc\Processor\Component\BasicProcessor;
use Mmc\Processor\Component\ChainProcessor;
use Mmc\Processor\Component\ResponseStatusCode;

class ChainProcessorTest extends \PHPUnit_Framework_TestCase
{
    private $chainProcessor;

    public function setup()
    {
        $this->chainProcessor = new ChainProcessor();

        $this->chainProcessor
            ->add(
                new BasicProcessor('foo', 'bar'),
                'p1',
                5
            )
            ->add(
                new BasicProcessor('foo', 'bar'),
                'p2',
                3
            )
            ->add(
                new BasicProcessor('bar', 'foo'),
                'p3',
                1
            )
        ;
    }

    public function testNotImplement()
    {
        $request = 'foobar';

        $this->assertFalse($this->chainProcessor->supports($request));

        $this->assertEquals(ResponseStatusCode::NOT_IMPLEMENTED, $this->chainProcessor->process($request)->getStatusCode());
    }

    public function testChain()
    {
        $request = 'foo';

        $this->assertTrue($this->chainProcessor->supports($request));
        $response = $this->chainProcessor->process($request);
        $this->assertEquals('bar', $response->getOutput());
        $this->assertEquals('p2', $response->getExtra('name'));
    }
}
