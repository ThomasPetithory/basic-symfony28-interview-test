<?php

namespace Test\InterviewBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultServiceTest extends WebTestCase
{
    public function testIndex()
    {
        // demande 14
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $service = $container->get('testinterview.biosservice');
        $this->assertSame('application/json', $service->getAllContributions()->headers->get('Content-Type')
        );
    }
}
