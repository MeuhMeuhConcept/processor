<?php

namespace Mmc\Processor\Component;

class BasicProcessor implements Processor
{
    protected $supportedInput;

    protected $supportedExpectedOutput;

    protected $output;

    public function __construct(
        $supportedInput,
        $supportedExpectedOutput,
        $output
    ) {
        $this->supportedInput = $supportedInput;
        $this->supportedExpectedOutput = $supportedExpectedOutput;
        $this->output = $output;
    }

    public function supports(Request $request)
    {
        if ($request->getInput() != $this->supportedInput) {
            return false;
        }

        if ($request->getExpectedOutput()
            && $request->getExpectedOutput() != $this->supportedExpectedOutput) {
            return false;
        }

        return true;
    }

    public function process(Request $request)
    {
        if ($this->supports($request)) {
            return new Response($request, $this->output);
        }

        return new Response($request, null, ResponseStatusCode::NOT_SUPPORTED);
    }
}
