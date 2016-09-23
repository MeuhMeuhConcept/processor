<?php

namespace Mmc\Processor;

use Mmc\Processor\Exception\OutputTypeException;

class Response
{
    private $request;

    private $output;

    private $statusCode;

    private $reasonPhrase;

    private $extras;

    public function __construct(
        Request $request,
        $output,
        $statusCode = ResponseStatusCode::OK,
        $reasonPhrase = ''
    ) {
        $this->request = $request;

        if (!ResponseStatusCode::isValidValue($statusCode)) {
            throw new \InvalidArgumentException('This statusCode is not valid');
        }

        $expectedOutput = $this->request->getExpectedOutput();
        if ($expectedOutput
            && !$output instanceof $expectedOutput
            && ($this->statusCode == ResponseStatusCode::OK || $output !== null)
        ) {
            throw new OutputTypeException('The output has to be an instance of '.$this->request->getExpectedOutput());
        }
        $this->output = $output;

        $this->statusCode = $statusCode;

        $this->reasonPhrase = $reasonPhrase;

        $this->extras = [];
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return int ResponseStatusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @return mixed
     */
    public function getExtra($key)
    {
        return $this->extras[$key];
    }

    /**
     * @param mixed $extra
     */
    public function setExtra($key, $extra)
    {
        $this->extras[$key] = $extra;

        return $this;
    }
}
