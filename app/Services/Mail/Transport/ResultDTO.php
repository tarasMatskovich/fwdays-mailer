<?php


namespace app\Services\Mail\Transport;

/**
 * Class ResultDTO
 * @package app\Services\Mail
 */
class ResultDTO
{
    /** @var string  */
    private $message;

    /** @var int  */
    private $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    public function print(): void
    {
        echo $this->message . "\r\n";
        echo "Answer code: " . $this->code . "\r\n";
    }
}
