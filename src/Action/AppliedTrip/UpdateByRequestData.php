<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\AppliedTrip;

use App\Entity\AppliedTrip;
use App\Repository\AppliedTripRepository;
use Exception;

/**
 * Class UpdateByRequestData
 */
class UpdateByRequestData
{
    private CheckRequestData $checkAppliedTripRequestData;

    private AppliedTripRepository $appliedTripRepository;

    /**
     * @param CheckRequestData      $checkAppliedTripRequestData
     * @param AppliedTripRepository $appliedTripRepository
     */
    public function __construct(
        CheckRequestData $checkAppliedTripRequestData,
        AppliedTripRepository $appliedTripRepository
    ) {
        $this->checkAppliedTripRequestData = $checkAppliedTripRequestData;
        $this->appliedTripRepository = $appliedTripRepository;
    }

    /**
     * @param array $requestData
     *
     * @return AppliedTrip
     * @throws Exception
     */
    public function execute(array $requestData): AppliedTrip
    {
        if (!$this->checkAppliedTripRequestData->checkForUpdate($requestData)) {
            throw new Exception('Invalid data!');
        }

        $appliedTrip = $this->appliedTripRepository->find(
            (int) $requestData['id']
        );
        if (!$appliedTrip) {
            throw new Exception('Invalid data!');
        }

        $appliedTrip->setStatus((int) $requestData['status']);

        try {
            $this->appliedTripRepository->save($appliedTrip, true);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $appliedTrip;
    }
}
