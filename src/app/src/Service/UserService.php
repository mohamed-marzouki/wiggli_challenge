<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *
 */
class UserService
{
    private UserRepository $userRepository;
    private EntityManager $manager;
    private Logger $logger;
    private Serializer $serializer;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param UserRepository $userRepository
     * @param $
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $managerRegistry, UserRepository $userRepository, SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->manager = $managerRegistry->getManager();
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        $result = [
            'result' => [],
            'status' => 'failed'
        ];
        try {
            $result['result'] = $this->userRepository->findAllUsers();
            $result['status'] = 'success';
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error($errorMessage = $e->getMessage());
        }
        return $result;
    }

    /**
     * @param User $
     * @return array
     */
    public function formatUser(User $user): array
    {
        $result = [
            'result' => [],
            'status' => 'failed'
        ];
        try {
            //avoid circular reference handler
            $encoder = new JsonEncoder();
            $defaultContext = [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                    return $object->getGroups();
                },
            ];
            $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
            $serializer = new Serializer([$normalizer], [$encoder]);

            $result['result'] = $serializer->normalize($user, null);
            $result['status'] = 'success';
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error($errorMessage = $e->getMessage());
        }
        return $result;
    }

    /**
     * @param User $user
     * @return void
     */
    public function removeUser(User $user)
    {
        $result = [
            'result' => 'An Error occured while removing user!',
            'status' => 'failed'
        ];
        try {
            $this->manager->remove($user);
            $this->manager->flush();
            $result['message'] = 'User has been removed successfuly!';
            $result['status'] = 'success';
        } catch (DBALException | NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error($errorMessage = $e->getMessage());
        }
        return $result;
    }

    /**
     * @param User $user
     * @param array $all
     * @return array
     */
    public function updateUser(User $user, array $newUserData): array
    {
        $result = [
            'message' => 'An Error occured while updating user!',
            'status' => 'failed'
        ];
        try {
            foreach ($newUserData as $key => $value) {
                $method = 'set' . ucfirst($key);
                $user->$method($value);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            $result['message'] = 'User has been updated successfuly!';
            $result['status'] = 'success';
        } catch (DBALException | NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error($errorMessage = $e->getMessage());
        }
        return $result;
    }
}