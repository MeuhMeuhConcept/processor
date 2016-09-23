<?php

namespace Mmc\Processor;

class Request
{
    private $input;

    private $expectedOutput;

    public function __construct($input, $expectedOutput = '')
    {
        $this->input = $input;
        if (!is_string($expectedOutput)) {
            throw new \InvalidArgumentException('ExpectedOutput must be a string');
        }
        $this->expectedOutput = $expectedOutput;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return string
     */
    public function getExpectedOutput()
    {
        return $this->expectedOutput;
    }
}
