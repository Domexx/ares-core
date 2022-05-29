<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Loader;

use DirectoryIterator;
use Ares\Framework\Exception\InvalidFileException;

class Directory extends Loader
{
    /**
     * Retrieve the contents of one or more configuration files in a directory
     * and convert them to an array of configuration options. Any invalid files
     * will be silently ignored.
     *
     * @throws InvalidFileException
     *
     * @return array Array of configuration options
     */
    public function getArray(): array
    {
        $contents = [];

        foreach (new DirectoryIterator($this->context) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $className = $file->isDir() ? 'Directory' : ucfirst(strtolower($file->getExtension()));
            $classPath = 'PHLAK\\Config\\Loaders\\' . $className;

            $loader = new $classPath($file->getPathname());

            try {
                $contents = array_merge($contents, $loader->getArray());
            } catch (InvalidFileException) {
                continue;
            }
        }

        return $contents;
    }
}
