<?php

namespace Mmc\Processor\Component\Tests;

use Mmc\Processor\Component\Response;
use Mmc\Processor\Component\ResponseStatusCode;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    protected $request;

    public function setup()
    {
        $this->request = 'request';
    }

    public function testConstructWithDefaultValuesAndGetters()
    {
        $output = new \stdClass();

        $response = new Response($this->request, $output);

        $this->assertEquals($this->request, $response->getRequest());
        $this->assertEquals($output, $response->getOutput());
        $this->assertEquals(ResponseStatusCode::OK, $response->getStatusCode());
        $this->assertEquals('', $response->getReasonPhrase());
    }

    public function testConstructAndGetters()
    {
        $output = new \stdClass();
        $statusCode = ResponseStatusCode::NOT_IMPLEMENTED;
        $reasonPhrase = 'reason_phrase';

        $response = new Response($this->request, $output, $statusCode, $reasonPhrase);
        $response->setExtra('foo', 'bar');

        $this->assertEquals($this->request, $response->getRequest());
        $this->assertEquals($output, $response->getOutput());
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
        $this->assertEquals('bar', $response->getExtra('foo'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadStatusCode()
    {
        $output = new \stdClass();

        $response = new Response($this->request, $output, 123);
    }
}
