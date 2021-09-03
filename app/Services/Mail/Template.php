<?php

declare(strict_types=1);

namespace app\Services\Mail;

/**
 * Class Template
 * @package app\Services\Mail
 */
class Template
{
    /** @var string */
    public $from;

    /** @var string  */
    public $to;

    /** @var string  */
    public $data;

    /** @var array  */
    public $headers;

    /**
     * Template constructor.
     * @param string $from
     * @param string $to
     * @param string $data
     * @param array $headers
     */
    public function __construct(
        string $from,
        string $to,
        string $data,
        array $headers = []
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
