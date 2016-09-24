<?php

namespace Mmc\Processor\Component;

class ChainProcessorItem
{
    private $processor;

    private $name;

    private $priority;

    public function __construct(
        Processor $processor,
        $name,
        $priority
    ) {
        $this->processor = $processor;
        $this->name = $name;
        $this->priority = $priority;
    }

    /**
     * @return Processor
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
