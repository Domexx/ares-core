<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Trait;

use ArrayIterator;
use Traversable;

/**
 * @Trait Arrayable
 */
trait Arrayable
{
    /**
     * Retrieve an the config array as an iterator.
     *
     * @return Traversable|ArrayIterator The conifg as a traversable iterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator(): Traversable|ArrayIterator
    {
        return new ArrayIterator($this->config);
    }

    /**
     * Determine whether an item exists at a specific offset.
     *
     * @param int $offset Offset to check for existence
     *
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset): bool
    {
        return isset($this->config[$offset]);
    }

    /**
     * Retrieve an item at a specific offset.
     *
     * @param int $offset Position of character to get
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset): mixed
    {
        return $this->config[$offset];
    }

    /**
     * Assign a value to the specified item at a specific offset.
     *
     * @param mixed $offset The offset to assign the value to
     * @param mixed $value The value to set
     */
    #[\ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->config[$offset] = $value;
    }

    /**
     * Unset an item at a specific offset.
     *
     * @param $offset
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): void
    {
        unset($this->config[$offset]);
    }
}
