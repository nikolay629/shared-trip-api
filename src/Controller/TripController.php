<?php

namespace App\Controller;

use App\Action\Trip\CreateByRequestData;
use App\Action\Trip\UpdateByRequestData;
use App\Entity\Trip;
use App\Helper\ResponseHelper;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TripController
 */
#[Route("/api/trip", name: "api_trip_")]
class TripController extends AbstractController
{
    private CreateByRequestData $createTripByRequestData;

    private UpdateByRequestData $updateTripByRequestData;

    /**
     * @param CreateByRequestData $createTripByRequestData
     * @param UpdateByRequestData $updateTripByRequestData
     */
    public function __construct(
        CreateByRequestData $createTripByRequestData,
        UpdateByRequestData $updateTripByRequestData
    ) {
        $this->createTripByRequestData = $createTripByRequestData;
        $this->updateTripByRequestData = $updateTripByRequestData;
    }

    /**
     * @param ManagerRegistry $managerRegistry
     *
     * @return JsonResponse
     */
    #[Route('/all', name: '', methods: 'GET')]
    public function getAll(ManagerRegistry $managerRegistry): JsonResponse
    {
        $tripRepository = $managerRegistry->getRepository(Trip::class);
        $trips = $tripRepository->findAll();

        $data = [];
        foreach ($trips as $trip) {
            /** @var Trip $trip */
            $data[] = $trip->getData();
        }

        return $this->json(ResponseHelper::prepareSuccess($data));
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @param int             $id
     *
     * @return JsonResponse
     */
    #[Route('/get-by-id/{id}', name: 'get_by_id', methods: 'GET')]
    public function getById(
        ManagerRegistry $managerRegistry,
        int $id
    ): JsonResponse {
        $tripRepository = $managerRegistry->getRepository(Trip::class);

        /** @var Trip $trip */
        $trip = $tripRepository->find($id);
        if ($trip) {
            $data[$trip->getId()] = $trip->getData();
            $response = ResponseHelper::prepareSuccess($data);
        } else {
            $data['message'] = sprintf('User with this id %d does not exist!', $id);
            $response = ResponseHelper::prepareError($data);
        }

        return $this->json($response);
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @param Request         $request
     *
     * @return JsonResponse
     */
    #[Route('/get', name: 'get', methods: 'POST')]
    public function get(
        ManagerRegistry $managerRegistry,
        Request $request
    ): JsonResponse {
        $requestData = json_decode($request->getContent(), true);
        $tripRepository = $managerRegistry->getRepository(Trip::class);

        $data = [];
        $trips = $tripRepository->findBy($requestData);
        foreach ($trips as $trip) {
            /** @var Trip $trip */
            $data[] = $trip->getData();
        }

        return $this->json(ResponseHelper::prepareSuccess($data));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/create', name: 'create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        try {
            $trip = $this->createTripByRequestData->execute($requestData);
            $response = ResponseHelper::prepareSuccess(
                [$trip->getId() => $trip->getData()]
            );
        } catch (Exception $exception) {
            $response = ResponseHelper::prepareError(
                ['message' => $exception->getMessage()]
            );
        }

        return $this->json($response);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/update', name: 'update', methods: 'POST')]
    public function update(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        try {
            $trip = $this->updateTripByRequestData->execute($requestData);
            $response = ResponseHelper::prepareSuccess(
                [$trip->getId() => $trip->getData()]
            );
        } catch (Exception $exception) {
            $response = ResponseHelper::prepareError(
                ['message' => $exception->getMessage()]
            );
        }

        return $this->json($response);
    }
}
