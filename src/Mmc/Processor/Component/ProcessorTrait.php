<?php

namespace Mmc\Processor\Component;

trait ProcessorTrait
{
    abstract public function supports($request);

    final public function process($request)
    {
        if (!$this->supports($request)) {
            return new Response($request, null, ResponseStatusCode::NOT_SUPPORTED);
        }

        try {
            $response = $this->doProcess($request);
        } catch (\Exception $e) {
            return new Response($request, $e, ResponseStatusCode::INTERNAL_ERROR, $e->getMessage());
        }

        if ($response === null) {
            return new Response($request, null, ResponseStatusCode::INTERNAL_ERROR);
        }

        if (!$response instanceof Response) {
            $response = new Response($request, $response, ResponseStatusCode::OK);
        }

        return $response;
    }

    abstract protected function doProcess($request);
}
