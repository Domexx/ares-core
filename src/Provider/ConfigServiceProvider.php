<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Provider;

use Ares\Framework\Exception\InvalidContextException;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Ares\Framework\Config;

/**
 * Class ConfigServiceProvider
 *
 * @package Ares\Framework\Provider
 */
class ConfigServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        Config::class
    ];

    /**
     * Registers new service.
     * @throws InvalidContextException
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Config::class, function () {
            return new Config(app_dir() . '/configs');
        });
    }
}
