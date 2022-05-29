<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Response\Handler;

use Ares\Framework\Response\ResponseType;
use Psr\Http\Message\ResponseInterface;

/**
 * Response type handler.
 */
interface ResponseTypeHandler
{
    /**
     * Handle response.
     *
     * @param ResponseType $responseType
     *
     * @return ResponseInterface
     */
    public function handle(ResponseType $responseType): ResponseInterface;
}