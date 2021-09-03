<?php

declare(strict_types=1);

namespace app\Services\Mail;

use app\Services\Mail\Transport\ResultDTO;
use app\Services\Mail\Transport\TransportInterface;

/**
 * Class MailService
 * @package app\Services\Mail
 */
class MailService
{
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * MailService constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function sendMail(Template $template): ResultDTO
    {
        return $this->transport->send($template);
    }
}
