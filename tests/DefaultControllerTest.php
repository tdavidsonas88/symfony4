<?php

namespace App\Tests;

use App\Entity\Video;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /** @var KernelBrowser  */
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    protected function tearDown() : void
    {
        $this->em->rollback();
        $this->em->close();
        $this->em = null; // to avoid memory leaks
    }

    public function testSomething()
    {
        $crawler = $this->client->request('GET', '/home');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Hello');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hello")')->count()
        );
//        $this->assertGreaterThan(0, $crawler->filter('h1.class')->count());
        $this->assertCount(1, $crawler->filter('h1'));
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'text/html; charset=UTF-8'
            ),
            'the "Content-Type" header is "application/json"'  // optional message shown on failure
        );
        $this->assertContains('This friendly message', $this->client->getResponse()->getContent());

    }

    public function testClickingTheLink()
    {
        $crawler = $this->client->request('GET', '/home');

        $link = $crawler
            ->filter('a:contains("awesome link")')
            ->link();

        $crawler = $this->client->click($link);
        $this->assertContains('Remember me', $this->client->getResponse()->getContent());
    }

    public function testSendingForm()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'user@user.com';
        $form['password'] = 'passwd';

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertEquals(1, $crawler->filter('a:contains("logout")')->count());
    }

    /**
     * @dataProvider provideUrls
     */
    public function testDataProviders($url)
    {
        $crawler = $this->client->request('GET', '/home');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return [
            ['/home'],
            ['/login']
        ];
    }

    /**
     * @throws ORMException
     */
    public function findVideo()
    {
        $crawler = $this->client->request('GET', '/home');
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $video = $this->em->getRepository(Video::class)->find(1);
        $this->em->remove($video);
        $this->em->flush();

        $this->assertNull($this->em
            ->getRepository(Video::class)
            ->find(1));
    }
}
