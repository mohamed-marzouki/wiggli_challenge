<?php

namespace App\Tests\Functional\Service;

use App\DataFixtures\GroupFixtures;
use App\Entity\Group;
use App\Entity\User;
use App\Repository\GroupRepository;
use App\Service\GroupService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

/**
 *
 */
class GroupServiceTest extends WebTestCase
{
    private GroupRepository $groupRepository;
    private $entityManager;
    private $groupService;
    private static $application;
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $container = static::getContainer();
        $this->databaseTool = $container->get(DatabaseToolCollection::class)->get();
        $this->entityManager = $container->get('doctrine')->getManager();
        $this->groupRepository = $container->get(GroupRepository::class);
        $this->groupService = $this->createMock(GroupService::class);
        $this->databaseTool->loadFixtures([
            GroupFixtures::class
        ]);
    }

    /**
     * @return void
     */
    public function testGetGroups()
    {
        $getGroupsReturn['result'] = $this->groupRepository->findAllGroups();
        $getGroupsReturn['message'] = 'success';
        $this->groupService->method('getGroups')->willReturn($getGroupsReturn);
        $this->assertEquals($this->expectedGroupsResult(), $this->groupService->getGroups(), 'Good :)');
    }

    /**
     * @return void
     */
    public function testGetGroupsException()
    {
        $getGroupsReturn['result'] = [];
        $getGroupsReturn['message'] = 'failed';
        $this->groupService->method('getGroups')->willReturn($getGroupsReturn);
        $this->assertEquals($this->expectedGroupsWithExceptionResult(), $this->groupService->getGroups(), 'Good :)');
    }

    /**
     * @return void
     */
    public function testAddGroup()
    {
        $user = (new User())->setLastName('UserLastName11')
            ->setFirstName('UserFirstName11')
            ->setAge(31)
            ->setEmail('user11@gmail.com')
            ->setPhone('06 00 00 00 00');
        $this->entityManager->persist($user);
        $addGroupData = [
            'name' => 'Admin',
            'description' => 'Admin description'
        ];
        $group = (new Group())
            ->setName($addGroupData['name'])
            ->setDescription($addGroupData['description'] ?? '')
            ->addUser($user);
        $this->entityManager->persist($group);
        $this->entityManager->flush();

        $result['result'] = $group;
        $result['message'] = 'success';
        $this->groupService->method('addGroup')->willReturn($result);
        $this->assertEquals(
            [
                'result' => $group,
                'message' => 'success'
            ],
            $this->groupService->addGroup($addGroupData)
        );

    }

    /**
     * @return array
     */
    private function expectedGroupsResult(): array
    {
        return array(
            'result' =>
                array(
                    0 =>
                        array(
                            'id' => 1,
                            'name' => 'Name0',
                            'description' => 'Descirpiton0',
                        ),
                    1 =>
                        array(
                            'id' => 2,
                            'name' => 'Name1',
                            'description' => 'Descirpiton1',
                        ),
                    2 =>
                        array(
                            'id' => 3,
                            'name' => 'Name2',
                            'description' => 'Descirpiton2',
                        ),
                    3 =>
                        array(
                            'id' => 4,
                            'name' => 'Name3',
                            'description' => 'Descirpiton3',
                        ),
                    4 =>
                        array(
                            'id' => 5,
                            'name' => 'Name4',
                            'description' => 'Descirpiton4',
                        ),
                    5 =>
                        array(
                            'id' => 6,
                            'name' => 'Name5',
                            'description' => 'Descirpiton5',
                        ),
                    6 =>
                        array(
                            'id' => 7,
                            'name' => 'Name6',
                            'description' => 'Descirpiton6',
                        ),
                    7 =>
                        array(
                            'id' => 8,
                            'name' => 'Name7',
                            'description' => 'Descirpiton7',
                        ),
                    8 =>
                        array(
                            'id' => 9,
                            'name' => 'Name8',
                            'description' => 'Descirpiton8',
                        ),
                    9 =>
                        array(
                            'id' => 10,
                            'name' => 'Name9',
                            'description' => 'Descirpiton9',
                        ),
                ),
            'message' => 'success',
        );
    }

    /**
     * @return array
     */
    private function expectedGroupsWithExceptionResult(): array
    {
        return [
            'result' => [],
            'message' => 'failed'
        ];
    }
}
