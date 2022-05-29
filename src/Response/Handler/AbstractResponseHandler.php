<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Response\Handler;

use Ares\Framework\Response\ResponseType;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Abstract response handler.
 */
abstract class AbstractResponseHandler implements ResponseTypeHandler
{
    /**
     * AbstractResponseHandler constructor.
     *
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(
        protected ResponseFactoryInterface $responseFactory
    ) {}

    /**
     * Get response.
     *
     * @param ResponseType $responseType
     *
     * @return ResponseInterface
     */
    protected function getResponse(ResponseType $responseType): ResponseInterface
    {
        return $responseType->getResponse() ?? $this->responseFactory->createResponse();
    }
}