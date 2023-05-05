<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\User;

use App\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CreateByRequestData
 */
class CreateByRequestData
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    public function execute(array $requestData): array
    {
        if (
            !isset($requestData['email'])
            || !isset($requestData['firstName'])
            || !isset($requestData['lastName'])
            || !isset($requestData['phone'])
            || !isset($requestData['age'])
            || !isset($requestData['password'])
        ) {
            return ['message' => 'Can`t create user without all data!'];
        }

        $hashedPassword = base64_encode($requestData['password']);

        $result = [];
        $user = new User();
        $user->setEmail((string) $requestData['email']);
        $user->setFirstName((string) $requestData['firstName']);
        $user->setLastName((string) $requestData['lastName']);
        $user->setPhone((string) $requestData['phone']);
        $user->setAge((int) $requestData['age']);
        $user->setPassword($hashedPassword);
        try {
            $this->managerRegistry->getManager()->persist($user);
            $this->managerRegistry->getManager()->flush($user);
            $result[$user->getId()] = $user->getData();
        } catch (ORMException $e) {
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

}
