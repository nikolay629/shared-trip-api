<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\AppliedTrip;

/**
 * Class CheckRequestData
 */
class CheckRequestData
{
    /**
     * @param array $requestData
     *
     * @return bool
     */
    public function checkForCreate(array $requestData): bool
    {
        return isset($requestData['trip']) && isset($requestData['user']);
    }

    /**
     * @param array $requestData
     *
     * @return bool
     */
    public function checkForUpdate(array $requestData): bool
    {
        return isset($requestData['id']) && isset($requestData['status']);
    }
}
