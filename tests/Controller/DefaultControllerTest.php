<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls(string $url): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', $url);

        self::assertResponseIsSuccessful(sprintf('The %s public URL loads correctly.', $url));
    }

    public function getPublicUrls(): ?\Generator
    {
        yield ['/'];
        yield ['/es/project/'];
        yield ['/en/project/new'];
    }
}
