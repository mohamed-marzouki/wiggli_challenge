<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    private const GROUP_INDEX_URL = 'en/api/group';

    /**
     * @return void
     * @test
     */
    public function index(): void
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', 'localhost:8007');
        $response = $client->request('GET', self::GROUP_INDEX_URL);
        $client->followRedirect(true);
        $this->assertResponseIsSuccessful();
        $this->assertJson($this->mockAllGroupsResponse(), $client->getResponse()->getContent());
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
}
