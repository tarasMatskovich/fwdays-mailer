<?php

declare(strict_types=1);


namespace app\Request;

use app\ContainerAdapter;
use app\Request\Validation\ConsoleRequestValidation;

/**
 * Class ConsoleRequest
 */
class ConsoleRequest
{
    /** @var string  */
    private $from;

    /** @var string  */
    private $to;

    /** @var string  */
    private $data;

    /** @var array  */
    private $headers;

    /**
     * ConsoleRequest constructor.
     * @param string $from
     * @param string $to
     * @param string $data
     * @param array $headers
     */
    public function __construct(
        string $from,
        string $to,
        string $data,
        array $headers
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * @param array $data
     * @return ConsoleRequest
     * @throws Validation\ValidationException
     */
    public static function createFromInput(array $data): self
    {
        /** @var ConsoleRequestValidation $validator */
        $validator = ContainerAdapter::get(ConsoleRequestValidation::class);
        $validator->validateRequestData($data);
        $headers = [];
        if ($data[3]) {
            $headers = explode(',', $data[3]);
        }
        return new self(
            $data[0],
            $data[1],
            $data[2],
            $headers
        );
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
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
}

