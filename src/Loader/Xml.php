<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Loader;

use Ares\Framework\Exception\InvalidFileException;

class Xml extends Loader
{
    /**
     * Retrieve the contents of a .json file and convert it to an array of
     * configuration options.
     *
     * @throws InvalidFileException
     *
     * @return array Array of configuration options
     */
    public function getArray(): array
    {
        $parsed = @simplexml_load_file($this->context);

        if (! $parsed) {
            throw new InvalidFileException('Unable to parse invalid XML file at ' . $this->context);
        }

        return json_decode(json_encode($parsed), true);
    }
}
