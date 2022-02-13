<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    private const GROUP_INDEX_URL = 'api/en/group';

    /**
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:8007');
        $response = $client->request('GET', self::GROUP_INDEX_URL);

        //$this->assertJson();
        //var_dump($client->getResponse());
        /**
        $response = $crawler = $client->request('GET', self::GROUP_INDEX_URL);
        $this->assertArrayHasKey();
var_dump($response->);die;
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Hello World');**/
    }
}
