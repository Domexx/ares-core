<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Mapping\Annotation;

/**
 * Argument annotation trait.
 */
trait ArgumentTrait
{
    /**
     * Arguments.
     *
     * @var array
     */
    protected array $arguments = [];

    /**
     * Get arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set arguments.
     *
     * @param array $arguments
     *
     * @return Group|ArgumentTrait|Route
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }
}