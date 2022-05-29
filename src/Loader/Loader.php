<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Loader;

use Ares\Framework\Interfaces\Loadable;

abstract class Loader implements Loadable
{
    /**
     * Create a new Loader object.
     *
     * @param string $context Path to configuration file or directory
     */
    public function __construct(
        protected string $context
    ) {}

    /**
     * Retrieve the context as an array of configuration options.
     *
     * @return array Array of configuration options
     */
    abstract public function getArray(): array;
}
