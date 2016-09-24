<?php

namespace Mmc\Processor\Component;

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
