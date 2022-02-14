<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class GroupControllerTest extends WebTestCase
{
    private const GROUP_INDEX_URL = 'en/api/group';
    private const GROUP_NEW_URL = 'en/api/group/new';

    /**
     * @return void
     * @test
     */
    public function index(): void
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:8007');
        $response = $client->request(Request::METHOD_GET, self::GROUP_INDEX_URL);
        $client->followRedirect(true);
        $this->assertResponseIsSuccessful();
        $this->assertJson($this->mockAllGroupsResponse(), $client->getResponse()->getContent());
    }

    /**
     * @return void
     * @test
     */
    public function new(): void
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:8007');
        $response = $client->request(Request::METHOD_POST, self::GROUP_NEW_URL, [
            'headers' => ['Content-Type' => 'application/json'],
            'group' => [
                'name' => 'admin',
                'description' => 'Admin description',
            ],
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJson($this->mockNewGroupResponse(), $client->getResponse()->getContent());
    }

    /**
     * @return array
     */
    private function mockAllGroupsResponse(): string
    {
        $result = [
            'result' => [],
            'message' => 'failed'
        ];
        for ($i = 0; $i < 10; $i++) {
            $result['result'][] = [
                'id' => $i + 1,
                'name' => 'Name' . $i,
                'description' => 'Descirpiton' . $i,
            ];
        }
        return json_encode($result);
    }

    /**
     * @return string
     */
    private function mockNewGroupResponse(): string
    {
        return '{"result":{},"message":"success"}';
    }
}
