<?php

use app\Application;
use app\Request\Validation\ConsoleRequestValidation;
use app\Services\Mail\Config;
use app\Services\Mail\MailService;
use app\Services\Mail\Transport\SMTPTransport;
use app\Services\Mail\Transport\TransportInterface;

return [
    Application::class => Application::class,
    ConsoleRequestValidation::class => ConsoleRequestValidation::class,
    Config::class => function () {
        return new Config(
            'ssl://smtp.gmail.com',
            465,
            'matskovich.taras.fwdays@gmail.com',
            'j23t7dXPP3'
        );
    },
    TransportInterface::class => SMTPTransport::class,
    MailService::class => MailService::class
];
