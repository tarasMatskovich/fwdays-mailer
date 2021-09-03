<?php

declare(strict_types=1);

namespace app;

use app\Request\Builder\RequestBuilder;
use app\Services\Mail\MailService;
use app\Services\Mail\Template;

/**
 * Class Application
 * @package app
 */
class Application
{
    /** @var RequestBuilder  */
    private $requestBuilder;

    /** @var MailService */
    private $mailService;

    /**
     * Application constructor.
     * @param RequestBuilder $requestBuilder
     * @param MailService $mailService
     */
    public function __construct(RequestBuilder $requestBuilder, MailService $mailService)
    {
        $this->requestBuilder = $requestBuilder;
        $this->mailService = $mailService;
    }

    public function run(): void
    {
        try {
            $request = $this->requestBuilder->buildRequest();
            $template = new Template(
                $request->getFrom(),
                $request->getTo(),
                $request->getData(),
                $request->getHeaders()
            );
            $result = $this->mailService->sendMail($template);
            $result->print();
        } catch (\Throwable $exception) {
            echo $exception->getMessage() . "\r\n";
            echo "Answer code: " . $exception->getCode();
        }
    }
}
