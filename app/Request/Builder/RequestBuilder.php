<?php

declare(strict_types=1);

namespace app\Request\Builder;

use app\Request\ConsoleRequest;

/**
 * Class RequestBuilder
 * @package app\Request\Builder
 */
class RequestBuilder
{
    /**
     * @return ConsoleRequest
     * @throws \app\Request\Validation\ValidationException
     */
    public function buildRequest(): ConsoleRequest
    {
        $data = [];
        $data[] = readline("Please write sender email: ");
        $data[] = readline("Please write recipient email: ");
        $data[] = readline("Please email data: ");
        $data[] = readline("Please add headers by example (header1,header2): ");

        return ConsoleRequest::createFromInput($data);
    }
}
