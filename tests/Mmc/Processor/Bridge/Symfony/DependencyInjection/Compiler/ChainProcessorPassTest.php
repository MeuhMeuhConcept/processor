<?php

namespace Mmc\Processor\Tests\Bridge\Symfony\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Mmc\Processor\Bridge\Symfony\DependencyInjection\Compiler\ChainProcessorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ChainProcessorPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ChainProcessorPass());
    }

    public function testCollectOfService()
    {
        $chain = new Definition();
        $chain->addTag('mmc.processor.chain');
        $this->setDefinition('my_chain', $chain);

        $p1 = new Definition();
        $p1->addTag('my_chain');
        $this->setDefinition('p1', $p1);

        $p2 = new Definition();
        $this->setDefinition('p2', $p2);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'my_chain',
            'add',
            [
                new Reference('p1'),
                'p1',
                10
            ]
        );
    }
}
