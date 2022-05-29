<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Response type interface.
 */
interface ResponseType
{
    /**
     * Get PSR-7 request.
     *
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * Get PSR-7 response.
     *
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface;
}