<?php
namespace App\Service;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 *
 */
class GroupService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;
    private $manager;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param GroupRepository $groupRepository
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $managerRegistry, GroupRepository $groupRepository, LoggerInterface $logger)
    {
        $this->groupRepository = $groupRepository;
        $this->logger = $logger;
        $this->manager = $managerRegistry->getManager();
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        $result = [
            'result' => [],
            'message' => 'failed'
        ];
        try {
            $result['result'] = $this->groupRepository->findAllGroups();
            $result['message'] = 'success';
        } catch(DBALException $e){
            $this->logger->error($e->getMessage());
        }catch(\Exception $e){
            $this->logger->error($errorMessage = $e->getMessage());
        }
        return $result;
    }

    /**
     * @param array $get
     * @return array
     */
    public function addGroup(array $group): array
    {
        $result = [
            'result' => [],
            'message' => 'failed'
        ];
        if (array_key_exists('name', $group)) {
            try {
                $group = (new Group())
                ->setName($group['name'])
                ->setDescription($group['description']?? '');
                $this->manager->persist($group);
                $this->manager->flush();
                $result['result'] = $group;
                $result['message'] = 'success';
                $this->logger->info('New group has been added successfulty!');
            } catch(DBALException $e){
                $this->logger->error($e->getMessage());
            }catch(\Exception $e){
                $this->logger->error($errorMessage = $e->getMessage());
            }
        }
        return $result;
    }
}