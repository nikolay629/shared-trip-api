<?php

namespace App\Controller;

use App\Action\AppliedTrip\CreateByRequestData;
use App\Action\AppliedTrip\UpdateByRequestData;
use App\Entity\AppliedTrip;
use App\Helper\ResponseHelper;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppliedTripController
 */
#[Route("/api/applied-trip", name: "api_applied_trip_")]
class AppliedTripController extends AbstractController
{

    private CreateByRequestData $createAppliedTripByRequestData;

    private UpdateByRequestData $updateAppliedTripByRequestData;

    /**
     * @param CreateByRequestData $createAppliedTripByRequestData
     * @param UpdateByRequestData $updateAppliedTripByRequestData
     */
    public function __construct(
        CreateByRequestData $createAppliedTripByRequestData,
        UpdateByRequestData $updateAppliedTripByRequestData
    ) {
        $this->createAppliedTripByRequestData = $createAppliedTripByRequestData;
        $this->updateAppliedTripByRequestData = $updateAppliedTripByRequestData;
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
        $appliedTripRepository = $managerRegistry->getRepository(AppliedTrip::class);

        $data = [];
        $appliedTrips = $appliedTripRepository->findBy($requestData);
        foreach ($appliedTrips as $appliedTrip) {
            /** @var AppliedTrip $appliedTrip */
            $data[] = $appliedTrip->getData();
        }

        return $this->json(ResponseHelper::prepareSuccess($data));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/apply', name: 'apply', methods: 'POST')]
    public function apply(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        try {
            $appliedTrip = $this->createAppliedTripByRequestData->execute(
                $requestData
            );
            $response = ResponseHelper::prepareSuccess(
                [$appliedTrip->getId() => $appliedTrip->getData()]
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
    #[Route('/change-status', name: 'change_status', methods: 'POST')]
    public function changeStatus(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        try {
            $appliedTrip = $this->updateAppliedTripByRequestData->execute(
                $requestData
            );
            $response = ResponseHelper::prepareSuccess(
                [$appliedTrip->getId() => $appliedTrip->getData()]
            );
        } catch (Exception $exception) {
            $response = ResponseHelper::prepareError(
                ['message' => $exception->getMessage()]
            );
        }

        return $this->json($response);
    }
}
