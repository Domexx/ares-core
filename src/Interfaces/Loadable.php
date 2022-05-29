<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Interfaces;

/**
 * Interface Loadable
 *
 * @package Ares\Framework\Interfaces
 */
interface Loadable
{
    /**
     * Retrieve the contents of one or more configuration files and convert them
     * to an array of configuration options.
     *
     * @return array Array of configuration options
     */
    public function getArray(): array;
}
