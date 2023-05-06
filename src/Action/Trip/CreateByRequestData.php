<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\Trip;

use App\Entity\Trip;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Exception;

/**
 * Class CreateByRequestData
 */
class CreateByRequestData
{
    private CheckRequestData $checkRequestData;

    private TripRepository $tripRepository;

    private UserRepository $userRepository;

    /**
     * @param CheckRequestData $checkRequestData
     * @param TripRepository   $tripRepository
     * @param UserRepository   $userRepository
     */
    public function __construct(
        CheckRequestData $checkRequestData,
        TripRepository $tripRepository,
        UserRepository $userRepository
    ) {
        $this->checkRequestData = $checkRequestData;
        $this->tripRepository = $tripRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $requestData
     *
     * @return Trip
     * @throws Exception
     */
    public function execute(array $requestData): Trip
    {
        if (!$this->checkRequestData->checkForCreate($requestData)) {
            throw new Exception(
                'Can`t create trip without all required data!'
            );
        }
        $user = $this->userRepository->find((int) $requestData['user']);
        if (!$user) {
            throw new Exception('User not exist');
        }

        $trip = new Trip();
        $trip->setCityFrom($requestData['cityFrom']);
        $trip->setCityTo($requestData['cityTo']);
        $trip->setHour($requestData['hour']);
        $trip->setDate($requestData['date']);
        $trip->setPrice((float) $requestData['price']);
        $trip->setSeats((int) $requestData['seats']);
        $trip->setStatus(1);
        $trip->setUser($user);
        $trip->setComment($requestData['comment'] ?? '');

        try {
            $this->tripRepository->save($trip, true);
        } catch (Exception $e) {
            throw new Exception(
                'Something went wrong with create trip!'
            );
        }

        return $trip;
    }
}
