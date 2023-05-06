<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * Class CreateByRequestData
 */
class CreateByRequestData
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $requestData
     *
     * @return User
     * @throws Exception
     */
    public function execute(array $requestData): User
    {
        if (
            !isset($requestData['email'])
            || !isset($requestData['firstName'])
            || !isset($requestData['lastName'])
            || !isset($requestData['phone'])
            || !isset($requestData['age'])
            || !isset($requestData['password'])
        ) {
            throw new Exception('Can`t create user without all data!');
        }

        $hashedPassword = base64_encode($requestData['password']);

        $user = new User();
        $user->setEmail((string) $requestData['email']);
        $user->setFirstName((string) $requestData['firstName']);
        $user->setLastName((string) $requestData['lastName']);
        $user->setPhone((string) $requestData['phone']);
        $user->setAge((int) $requestData['age']);
        $user->setPassword($hashedPassword);

        try {
            $this->userRepository->save($user, true);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $user;
    }

}
