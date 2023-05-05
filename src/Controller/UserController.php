<?php

namespace App\Controller;

use App\Action\User\CheckRequestData;
use App\Action\User\CreateByRequestData;
use App\Action\User\UpdateByRequestData;
use App\Entity\User;
use App\Helper\ResponseHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 */
#[Route("/api/user", name: "api_user_")]
class UserController extends AbstractController
{
    private CheckRequestData $checkCredentials;

    private CreateByRequestData $createUserByRequestData;

    private UpdateByRequestData $updateUserByRequestData;

    /**
     * @param CheckRequestData    $checkCredentials
     * @param CreateByRequestData $createUserByRequestData
     * @param UpdateByRequestData $updateUserByRequestData
     */
    public function __construct(
        CheckRequestData $checkCredentials,
        CreateByRequestData $createUserByRequestData,
        UpdateByRequestData $updateUserByRequestData
    ) {
        $this->checkCredentials = $checkCredentials;
        $this->createUserByRequestData = $createUserByRequestData;
        $this->updateUserByRequestData = $updateUserByRequestData;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route("/login", name: "login", methods:"POST")]
    public  function login(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $data = $this->checkCredentials->checkLoginRequestData($requestData);
        if (isset($data['message'])) {
            $response = ResponseHelper::prepareError($data);
        } else {
            $response = ResponseHelper::prepareSuccess($data);
        }

        return $this->json($response);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $data = $this->createUserByRequestData->execute($requestData);
        if (isset($data['message'])) {
            $response = ResponseHelper::prepareError($data);
        } else {
            $response = ResponseHelper::prepareSuccess($data);
        }

        return $this->json($response);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/resetPassword', name: 'reset_password', methods: 'POST')]
    public function resetPassword(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if ($this->updateUserByRequestData->resetPassword($requestData)) {
            $response = ResponseHelper::prepareSuccess(
                ['message' => 'Password changed successfully!']
            );
        } else {
            $response = ResponseHelper::prepareError(
                ['message' => 'Invalid data!']
            );
        }

        return $this->json($response);
    }

    /**
     * @param ManagerRegistry $managerRegistry
     *
     * @return JsonResponse
     */
    #[Route("/all", name: "all", methods:"GET")]
    public function getAll(ManagerRegistry $managerRegistry): JsonResponse
    {
        $data = $this->getByCriteria($managerRegistry, []);

        if (!empty($data)) {
            $response = ResponseHelper::prepareSuccess($data);
        } else {
            $response = ResponseHelper::prepareError(
                ['message' => 'Don`t have any user!']
            );
        }

        return $this->json($response);
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @param int             $id
     *
     * @return JsonResponse
     */
    #[Route("/getById/{id}", name: "get_by_id", methods:"GET")]
    public function getById(
        ManagerRegistry $managerRegistry,
        int $id
    ): JsonResponse {
        $userRepository = $managerRegistry->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository->find($id);
        if ($user) {
            $data[$user->getId()] = $user->getData();
            $response = ResponseHelper::prepareSuccess($data);
        } else {
            $data['message'] = sprintf('User with this id %d does not exist!', $id);
            $response = ResponseHelper::prepareError($data);
        }

        return $this->json($response);
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @param string          $email
     *
     * @return JsonResponse
     */
    #[Route("/getByEmail/{email}", name: "get_by_email", methods:"GET")]
    public function getByEmail(
        ManagerRegistry $managerRegistry,
        string $email
    ): JsonResponse {
        $criteria = ['email' => $email];
        $data = $this->getByCriteria($managerRegistry, $criteria);

        if ($data) {
            $response = ResponseHelper::prepareSuccess($data);
        } else {
            $data['message'] = sprintf('User with email %s does not exist!', $email);
            $response = ResponseHelper::prepareError($data);
        }

        return $this->json($response);
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @param array           $criteria
     *
     * @return array
     */
    private function getByCriteria(
        ManagerRegistry $managerRegistry,
        array $criteria
    ): array {
        $userRepository = $managerRegistry->getRepository(User::class);
        $users = $userRepository->findBy($criteria);

        $data = [];
        foreach ($users as $user) {
            /** @var User $user */
            $data[$user->getId()] = $user->getData();
        }
        return $data;
    }
}
