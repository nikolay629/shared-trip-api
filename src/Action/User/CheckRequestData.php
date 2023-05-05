<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\User;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class CheckCredentials
 */
class CheckRequestData
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    public function checkLoginRequestData(array $requestData): array
    {
        if (!isset($requestData['email']) || !isset($requestData['password'])) {
            return ['message' => 'Email and Password can`t be empty!'];
        }

        $email    = trim($requestData['email']);
        $password = trim($requestData['password']);
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return [
                'message' => sprintf(
                    'Could not find user with email: %s', $email
                )
            ];
        }

        $result   = [];
        if ($this->checkPassword($user, $password)) {
            $result[$user->getId()] = $user->getData();
        } else {
            $result['message'] = 'Invalid credentials!';
        }

        return $result;
    }

    /**
     * @param User   $user
     * @param string $password
     *
     * @return bool
     */
    private function checkPassword(User $user, string $password): bool
    {
        return base64_decode($user->getPassword()) == $password;
    }
}
