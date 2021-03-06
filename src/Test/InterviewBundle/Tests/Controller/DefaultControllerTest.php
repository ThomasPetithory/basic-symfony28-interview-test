<?php

namespace Test\InterviewBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        //Demande 13
        $client->request('GET', '/hello');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json',  $client->getResponse()->headers->get('Content-Type'));

        $client->request('GET', '/contributions');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/contributions/fake');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $client->request('GET', '/contributions/OOP');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
