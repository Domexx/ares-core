<?php

namespace Ares\Framework\Loader;

use Ares\Framework\Exception\InvalidFileException;

class Ini extends Loader
{
    /**
     * Retrieve the contents of a .ini file and convert it to an array of
     * configuration options.
     *
     * @throws \Ares\Framework\Exception\InvalidFileException
     *
     * @return array Array of configuration options
     */
    public function getArray(): array
    {
        $parsed = @parse_ini_file($this->context, true);

        if (! $parsed) {
            throw new InvalidFileException('Unable to parse invalid INI file at ' . $this->context);
        }

        return $parsed;
    }
}
