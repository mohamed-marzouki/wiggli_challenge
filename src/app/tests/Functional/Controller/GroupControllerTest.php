<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    private const GROUP_INDEX_URL = 'en/api/group';

    /**
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:8007');
        $response = $client->request('GET', self::GROUP_INDEX_URL);
        $client->followRedirect(true);
        $this->assertResponseIsSuccessful();

        dd($client->getResponse()->getContent());
    }
}
