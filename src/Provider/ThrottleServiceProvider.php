<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Provider;

use Ares\Framework\Middleware\ThrottleMiddleware;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Ares\Framework\Config;
use Predis\Client;

/**
 * Class ThrottleServiceProvider
 *
 * @package Ares\Framework\Provider
 */
class ThrottleServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        ThrottleMiddleware::class
    ];

    /**
     * Registers new service.
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(ThrottleMiddleware::class, function () use ($container) {
            $config = $container->get(Config::class);

            $predis = new Client([
                'host' => $_ENV['CACHE_REDIS_HOST'],
                'port' => (int) $_ENV['CACHE_REDIS_PORT']
            ]);

            $throttleMiddleware = new ThrottleMiddleware($predis);
            $throttleMiddleware
                ->setRateLimit(
                    $config->get('api_settings.throttle.rate_limit_requests'),
                    $config->get('api_settings.throttle.rate_limit_per_second')
                )
                ->setStorageKey('ARES_API_THROTTLE:%s');

            return $throttleMiddleware;
        });
    }
}
