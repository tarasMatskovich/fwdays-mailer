<?php

declare(strict_types=1);

namespace app\Request\Validation;

/**
 * Class ConsoleRequestValidation
 */
class ConsoleRequestValidation
{
    /**
     * @param array $requestData
     * @throws ValidationException
     */
    public function validateRequestData(array $requestData): void
    {
        if (count($requestData) < 4) {
            throw new ValidationException('Invalid arguments in console request');
        }
        foreach ($requestData as $key => $value) {
            if (!$value && $key !== 3) {
                throw new ValidationException('Invalid arguments in console request');
            }
        }
    }
}
