<?php

declare(strict_types=1);

namespace app\Services\Mail;

/**
 * Class Config
 * @package app\Services\Mail
 */
class Config
{
    /** @var string  */
    private $host;

    /** @var int  */
    private $port;

    /** @var string  */
    private $user;

    /** @var string  */
    private $password;

    /**
     * Config constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     */
    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
