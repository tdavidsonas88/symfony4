<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Hello');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hello")')->count()
        );
//        $this->assertGreaterThan(0, $crawler->filter('h1.class')->count());
        $this->assertCount(1, $crawler->filter('h1'));
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'text/html; charset=UTF-8'
            ),
            'the "Content-Type" header is "application/json"'  // optional message shown on failure
        );
        $this->assertContains('This friendly message', $client->getResponse()->getContent());

    }

    public function testClickingTheLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $link = $crawler
            ->filter('a:contains("awesome link")')
            ->link();

        $crawler = $client->click($link);
        $this->assertContains('Remember me', $client->getResponse()->getContent());
    }
}
