<?php
/**
 * @package App\Action
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Action\Trip;

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
        return
            isset($requestData['cityFrom'])
            && isset($requestData['cityTo'])
            && isset($requestData['hour'])
            && isset($requestData['date'])
            && isset($requestData['price'])
            && isset($requestData['seats'])
            && isset($requestData['user']);
    }
}
