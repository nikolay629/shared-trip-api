<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\User;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UpdateByRequestData
 */
class UpdateByRequestData
{

    private ManagerRegistry $managerRegistry;

    private UserRepository $userRepository;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param UserRepository  $userRepository
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        UserRepository $userRepository
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $requestData
     *
     * @return bool
     */
    public function resetPassword(array $requestData): bool
    {
        if (!isset($requestData['userId']) || !isset($requestData['newPassword'])) {
            return false;
        }

        $user = $this->userRepository->find($requestData['userId']);
        if (!$user) {
            return false;
        }

        $hashPassword = base64_encode($requestData['newPassword']);
        $user->setPassword($hashPassword);

        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return true;
    }
}
