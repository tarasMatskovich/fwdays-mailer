<?php

declare(strict_types=1);

namespace app\Services\Mail\Transport;

use app\Services\Mail\Template;

/**
 * Interface TransportInterface
 * @package app\Services\Mail\Transport
 */
interface TransportInterface
{
    /**
     * @param Template $template
     * @return ResultDTO
     */
    public function send(Template $template): ResultDTO;
}
