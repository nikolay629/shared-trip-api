<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\Trip;

use App\Entity\Trip;
use App\Repository\TripRepository;
use Exception;

/**
 * Class UpdateByRequestData
 */
class UpdateByRequestData
{

    private TripRepository $tripRepository;

    /**
     * @param TripRepository $tripRepository
     */
    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * @param array $requestData
     *
     * @return Trip
     * @throws Exception
     */
    public function execute(array $requestData): Trip
    {
        $trip = $this->tripRepository->find((int) ($requestData['id'] ?? 0));
        if (!$trip) {
            throw new Exception('Can`t found trip!');
        }

        $trip->setData($requestData);
        try {
            $this->tripRepository->save($trip, true);
        } catch (Exception $exception) {
            throw new Exception('Can`t update trip');
        }

        return $trip;
    }

}
