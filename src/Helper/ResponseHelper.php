<?php
/**
 * @package App\Helper
 * @author  Stenik Magento Team <magedev@stenik.bg>
 */

declare(strict_types=1);

namespace App\Helper;

/**
 * Class Response
 */
class ResponseHelper
{
    const SUCCESS = 'success';
    const ERROR = 'error';

    /**
     * @param array $data
     *
     * @return array
     */
    public static function prepareSuccess(array $data): array
    {
        $response = [];

        $response['status'] = self::SUCCESS;
        $response['result'] = $data;
        return $response;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public static function prepareError(array $data): array
    {
        $response = [];

        $response['status'] = self::ERROR;
        $response['error'] = $data;
        return $response;
    }

}
