<?php
namespace App\Service;

use App\Repository\GroupRepository;
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

    /**
     * @param GroupRepository $groupRepository
     * @param LoggerInterface $logger
     */
    public function __construct(GroupRepository $groupRepository, LoggerInterface $logger)
    {
        $this->groupRepository = $groupRepository;
        $this->logger = $logger;
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
}