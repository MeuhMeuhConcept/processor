<?php

namespace Mmc\Processor\Component;

class Response
{
    private $request;

    private $output;

    private $statusCode;

    private $reasonPhrase;

    private $extras;

    public function __construct(
        $request,
        $output,
        $statusCode = ResponseStatusCode::OK,
        $reasonPhrase = ''
    ) {
        $this->request = $request;

        if (!ResponseStatusCode::isValidValue($statusCode)) {
            throw new \InvalidArgumentException('This statusCode is not valid');
        }

        $this->output = $output;

        $this->statusCode = $statusCode;

        $this->reasonPhrase = $reasonPhrase;

        $this->extras = [];
    }

    /**
     * @return mixed
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
        return isset($this->extras[$key]) ? $this->extras[$key] : null;
    }

    /**
     * @param mixed $extra
     */
    public function setExtra($key, $extra)
    {
        $this->extras[$key] = $extra;

        return $this;
    }

    public function isSuccessed()
    {
        return $this->getStatusCode() == ResponseStatusCode::OK;
    }
}
