<?php

declare(strict_types=1);

namespace app\Services\Mail\Transport;

use app\Services\Mail\Config;
use app\Services\Mail\Template;

/**
 * Class SMTPTransport
 * @package app\Services\Mail\Transport
 */
class SMTPTransport implements TransportInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * SMTPTransport constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Template $template
     * @return ResultDTO
     * @throws TransportException
     */
    public function send(Template $template): ResultDTO
    {
        $socket = $this->createSocket();
        $this->hello($socket);
        $this->auth($socket);
        $this->from($socket, $template);
        $this->to($socket, $template);
        $code = $this->data($socket, $template);
        $this->close($socket);
        return new ResultDTO('Mail was successfully send', $code);
    }

    /**
     * @return false|resource
     * @throws TransportException
     */
    private function createSocket()
    {
        $socket = fsockopen($this->config->getHost(), $this->config->getPort()) or die ('Не могу соединиться');
        $msg = '';
        while ($line = fgets($socket, 515)) {
            $msg .= $line;
            if (substr($line, 3, 1) == " ") break;
        }
        $answer = substr($msg, 0, 3);
        if($answer != '220') {
            throw new TransportException('Error on connection to SMTP server', (int)$answer);
        }

        return $socket;
    }

    /**
     * @throws TransportException
     */
    private function hello($socket): void
    {
        $localhost = '127.0.0.1';
        $answer = $this->sendSMTPCommand($socket, 'HELO '.$localhost);
        if ($answer !== "250") {
            throw new TransportException('Error on hello', (int)$answer);
        }
    }

    /**
     * @throws TransportException
     */
    private function auth($socket): void
    {
        $answer = $this->sendSMTPCommand($socket, 'AUTH LOGIN');
        if($answer !== '334') {
            throw new TransportException('SMTP server auth error', (int)$answer);
        }
        $answer = $this->sendSMTPCommand($socket, base64_encode($this->config->getUser()));
        if($answer !== '334') {
            throw new TransportException('SMTP server auth error: incorrect user name', (int)$answer);
        }
        $answer = $this->sendSMTPCommand($socket, base64_encode($this->config->getPassword()));
        if($answer !== '235') {
            throw new TransportException('SMTP server auth error: incorrect password', (int)$answer);
        }
    }

    /**
     * @param Template $template
     * @throws TransportException
     */
    private function from($socket, Template $template): void
    {
        $templateFrom = $template->getFrom();
        $from = "<$templateFrom>";
        $answer = $this->sendSMTPCommand($socket, 'MAIL FROM:'.$from);
        if($answer !== '250') {
            throw new TransportException('SMTP error on command MAIL FROM', (int)$answer);
        };
    }

    /**
     * @param Template $template
     * @throws TransportException
     */
    private function to($socket, Template $template): void
    {
        $templateTo = $template->getTo();
        $to = "<$templateTo>";
        $answer = $this->sendSMTPCommand($socket, 'RCPT TO:'.$to);
        if($answer !== '250') {
            throw new TransportException('SMTP error on command RCPT TO', (int)$answer);
        }
    }

    /**
     * @param Template $template
     * @return int
     * @throws TransportException
     */
    private function data($socket, Template $template): int
    {
        $answer = $this->sendSMTPCommand($socket, "DATA");
        if($answer !== '354') {
            throw new TransportException('SMTP error on command DATA', (int)$answer);
        };
        $headers = $template->getHeaders();
        $headers[] = 'Content-Type: text/html; charset="UTF-8"';
        $headers[] = 'Content-Transfer-Encoding: 7bit;';
        $data = "";
        foreach ($headers as $header) {
            $data .= (string)$header . "\r\n";
        }
        if (!empty($headers)) {
            $data .= "\r\n";
        }
        $data .= $template->getData();
        fputs($socket, $data."\r\n");
        $answer = $this->sendSMTPCommand($socket, ".");
        if($answer !== '250') {
            throw new TransportException('SMTP error on sending DATA', $answer);
        }

        return (int)$answer;
    }

    /**
     * @throws TransportException
     */
    private function close($socket)
    {
        $answer = $this->sendSMTPCommand($socket, "QUIT");
        if($answer !== '221') {
            throw new TransportException('Can not close connection with SMTP server', (int)$answer);
        }
        fclose($socket);
    }

    /**
     * @param string $cmd
     * @return string
     */
    private function sendSMTPCommand($socket, string $cmd): string
    {
        $SMTPMessage  = "";
        fputs( $socket, $cmd."\r\n" );
        while ($line = fgets($socket, 515)) {
            $SMTPMessage .= $line;
            if (substr($line, 3, 1) == " ") break;
        }
        $code = (string)substr( $SMTPMessage, 0, 3 );
        return $code;
    }
}

