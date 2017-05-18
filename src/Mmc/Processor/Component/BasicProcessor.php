<?php

namespace Mmc\Processor\Component;

class BasicProcessor implements Processor
{
    protected $supportedInput;

    protected $output;

    public function __construct(
        $supportedInput,
        $output
    ) {
        $this->supportedInput = $supportedInput;
        $this->output = $output;
    }

    public function supports($request)
    {
        if ($request != $this->supportedInput) {
            return false;
        }

        return true;
    }

    public function process($request)
    {
        if ($this->supports($request)) {
            return new Response($request, $this->output);
        }

        return new Response($request, null, ResponseStatusCode::NOT_SUPPORTED);
    }
}
