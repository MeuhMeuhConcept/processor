<?php

namespace Mmc\Processor\Component;

trait ChainProcessorTrait
{
    protected $processors = [];

    public function add(Processor $processor, $name = '', $priority = 10)
    {
        $this->processors[] = new ChainProcessorItem($processor, $name, $priority);

        usort($this->processors, function ($a, $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return $this;
    }

    public function supports($request)
    {
        foreach ($this->processors as $item) {
            if ($item->getProcessor()->supports($request)) {
                return true;
            }
        }

        return false;
    }

    protected function doProcess($request)
    {
        $item = $this->findProcessor($request);

        if ($item) {
            $response = $item->getProcessor()->process($request);
            $response->setExtra('name', $item->getName());

            return $response;
        }
    }

    /**
     * @deprecated Will be removed on 3.0, use findProcessor instead
     */
    protected function findItem($request)
    {
        return $this->findProcessor($request);
    }

    protected function findProcessor($request)
    {
        foreach ($this->processors as $item) {
            $processor = $item->getProcessor();
            if ($processor->supports($request)) {
                return $item;
            }
        }
    }
}
