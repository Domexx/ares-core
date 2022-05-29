<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Mapping\Annotation;

use Jgut\Mapping\Exception\AnnotationException;

/**
 * Middleware annotation trait.
 */
trait MiddlewareTrait
{
    /**
     * Middleware list.
     *
     * @var array
     */
    protected array $middleware = [];

    /**
     * Get middleware list.
     *
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * Set middleware list.
     *
     * @param array|string $middlewareList
     *
     * @return Group|MiddlewareTrait|Route
     */
    public function setMiddleware(array|string $middlewareList): self
    {
        $this->middleware = [];

        if (!\is_array($middlewareList)) {
            $middlewareList = [$middlewareList];
        }

        /** @var array $middlewareList */
        foreach ($middlewareList as $middleware) {
            if (!\is_string($middleware)) {
                throw new AnnotationException(
                    \sprintf('Route annotation middleware must be strings. "%s" given', \gettype($middleware))
                );
            }

            $this->middleware[] = $middleware;
        }

        return $this;
    }
}