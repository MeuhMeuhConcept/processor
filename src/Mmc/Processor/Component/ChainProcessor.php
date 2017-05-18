<?php

namespace Mmc\Processor\Component;

class ChainProcessor extends AbstractProcessor
{
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(Processor $processor, $name = '', $priority = 10)
    {
        $this->items[] = new ChainProcessorItem($processor, $name, $priority);

        usort($this->items, function ($a, $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return $this;
    }

    public function supports($request)
    {
        foreach ($this->items as $item) {
            if ($item->getProcessor()->supports($request)) {
                return true;
            }
        }

        return false;
    }

    protected function doProcess($request)
    {
        foreach ($this->items as $item) {
            $processor = $item->getProcessor();
            if ($processor->supports($request)) {
                $response = $processor->process($request);
                $response->setExtra('name', $item->getName());

                return $response;
            }
        }
    }
}
