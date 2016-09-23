<?php

namespace Mmc\Processor;

interface Processor
{
    /**
     * Return if the processor can proceed this request.
     *
     * @return bool
     */
    public function supports(Request $request);

    /**
     * Try to proceed this request.
     *
     * @return Response
     */
    public function process(Request $request);
}
