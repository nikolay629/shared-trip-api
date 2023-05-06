<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\AppliedTrip;

use App\Entity\AppliedTrip;
use App\Repository\AppliedTripRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use Exception;

/**
 * Class CreateByRequestData
 */
class CreateByRequestData
{
    private CheckRequestData $checkAppliedTripRequestData;

    private AppliedTripRepository $appliedTripRepository;

    private TripRepository $tripRepository;

    private UserRepository $userRepository;

    /**
     * @param CheckRequestData      $checkAppliedTripRequestData
     * @param AppliedTripRepository $appliedTripRepository
     * @param TripRepository        $tripRepository
     * @param UserRepository        $userRepository
     */
    public function __construct(
        CheckRequestData $checkAppliedTripRequestData,
        AppliedTripRepository $appliedTripRepository,
        TripRepository $tripRepository,
        UserRepository $userRepository
    ) {
        $this->checkAppliedTripRequestData = $checkAppliedTripRequestData;
        $this->appliedTripRepository = $appliedTripRepository;
        $this->tripRepository = $tripRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $requestData
     *
     * @return AppliedTrip
     * @throws Exception
     */
    public function execute(array $requestData): AppliedTrip
    {
        if (!$this->checkAppliedTripRequestData->checkForCreate($requestData)) {
            throw new Exception(
                'Can`t apply for trip without all data!'
            );
        }

        $user = $this->userRepository->find((int) $requestData['user']);
        if (!$user) {
            throw new Exception('Invalid user id!');
        }

        $trip = $this->tripRepository->find((int) $requestData['trip']);
        if (!$trip) {
            throw new Exception('Invalid trip id!');
        }

        $appliedTrip = new AppliedTrip();
        $appliedTrip->setTrip($trip);
        $appliedTrip->setUser($user);
        $appliedTrip->setStatus(0);

        try {
            $this->appliedTripRepository->save($appliedTrip, true);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $appliedTrip;
    }
}
