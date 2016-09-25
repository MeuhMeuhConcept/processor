<?php

namespace Mmc\Processor\Bridge\Symfony\Bundle;

use Mmc\Processor\Bridge\Symfony\DependencyInjection\Compiler\ChainProcessorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MmcProcessorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ChainProcessorPass());
    }
}
