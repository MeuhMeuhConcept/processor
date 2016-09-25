<?php

namespace Mmc\Processor\Tests\Bridge\Symfony\Bundle;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Mmc\Processor\Bridge\Symfony\Bundle\MmcProcessorBundle;

class ProcessorBundleTest extends AbstractContainerBuilderTestCase
{
    public function testBuild()
    {
        $bundle = new MmcProcessorBundle();
        $bundle->build($this->container);
    }
}
