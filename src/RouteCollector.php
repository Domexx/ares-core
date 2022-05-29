<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework;

use Jgut\Mapping\Driver\DriverFactoryInterface;
use Ares\Framework\Mapping\Metadata\RouteMetadata;
use Ares\Framework\Route\Route;
use Ares\Framework\Route\RouteResolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\InvocationStrategyInterface;
use Slim\Interfaces\RouteInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteCollector as SlimRouteCollector;

/**
 * Route loader collector.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RouteCollector extends SlimRouteCollector
{
    /**
     * Metadata cache.
     *
     * @var CacheInterface|null
     */
    protected ?CacheInterface $cache;

    /**
     * Metadata cache prefix.
     *
     * @var string
     */
    protected string $cachePrefix = '';

    /**
     * Mapping routes have been loaded.
     *
     * @var bool
     */
    private bool $routesRegistered = false;

    /**
     * RouteCollector constructor.
     *
     * @param Configuration                    $configuration
     * @param ResponseFactoryInterface         $responseFactory
     * @param CallableResolverInterface        $callableResolver
     * @param ContainerInterface|null          $container
     * @param InvocationStrategyInterface|null $defaultInvocationStrategy
     * @param RouteParserInterface|null        $routeParser
     * @param string|null                      $cacheFile
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function __construct(
        protected Configuration $configuration,
        ResponseFactoryInterface $responseFactory,
        CallableResolverInterface $callableResolver,
        ?ContainerInterface $container = null,
        ?InvocationStrategyInterface $defaultInvocationStrategy = null,
        ?RouteParserInterface $routeParser = null,
        ?string $cacheFile = null
    ) {
        parent::__construct(
            $responseFactory,
            $callableResolver,
            $container,
            $defaultInvocationStrategy,
            $routeParser,
            $cacheFile
        );
    }

    /**
     * Set metadata cache.
     *
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * Set metadata cache prefix.
     *
     * @param string $cachePrefix
     */
    public function setCachePrefix(string $cachePrefix): void
    {
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function getRoutes(): array
    {
        if ($this->routesRegistered === false) {
            $this->registerRoutes();
        }

        return $this->routes;
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function lookupRoute(string $identifier): RouteInterface
    {
        if ($this->routesRegistered === false) {
            $this->registerRoutes();
        }

        return parent::lookupRoute($identifier);
    }

    /**
     * Register routes.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws InvalidArgumentException
     */
    final public function registerRoutes(): void
    {
        $routes = $this->routes;
        $this->routes = [];

        $resolver = $this->configuration->getRouteResolver();

        foreach ($this->getRoutesMetadata() as $routeMetadata) {
            $route = $this->mapMetadataRoute($routeMetadata, $resolver);

            $name = $resolver->getName($routeMetadata);
            if ($name !== null) {
                $route->setName($name);
            }
            $arguments = $resolver->getArguments($routeMetadata);
            if (\count($arguments) !== 0) {
                $route->setArguments($arguments);
            }

            foreach ($resolver->getMiddleware($routeMetadata) as $middleware) {
                $route->add($middleware);
            }
        }

        $this->routes = \array_merge($this->routes, $routes);

        $this->routesRegistered = true;
    }

    /**
     * Get routes metadata.
     *
     * @return RouteMetadata[]
     * @throws InvalidArgumentException
     */
    protected function getRoutesMetadata(): array
    {
        $mappingSources = $this->configuration->getSources();
        $cacheKey = $this->getCacheKey($mappingSources);

        if ($this->cache !== null && $this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        /** @var RouteMetadata[] $routes */
        $routes = $this->configuration->getMetadataResolver()->getMetadata($mappingSources);

        $routeResolver = $this->configuration->getRouteResolver();
        $routeResolver->checkDuplicatedRoutes($routes);

        $routes = $routeResolver->sort($routes);

        if ($this->cache !== null) {
            $this->cache->set($cacheKey, $routes);
        }

        return $routes;
    }

    /**
     * Map new metadata route.
     *
     * @param RouteMetadata $metadata
     * @param RouteResolver $resolver
     *
     * @return Route
     */
    protected function mapMetadataRoute(RouteMetadata $metadata, RouteResolver $resolver): Route
    {
        $route = $this->createMetadataRoute(
            $metadata->getMethods(),
            $resolver->getPattern($metadata),
            $metadata->getInvokable(),
            $metadata
        );

        $this->routes[$route->getIdentifier()] = $route;
        $this->routeCounter++;

        return $route;
    }

    /**
     * @param array $methods
     * @param string  $pattern
     * @param mixed   $handler
     *
     * @return RouteInterface
     */
    final protected function createRoute(array $methods, string $pattern, $handler): RouteInterface
    {
        return $this->createMetadataRoute($methods, $pattern, $handler);
    }

    /**
     * Create new metadata aware route.
     *
     * @param string[]           $methods
     * @param string             $pattern
     * @param mixed              $callable
     * @param RouteMetadata|null $metadata
     *
     * @return Route
     */
    protected function createMetadataRoute(
        array          $methods,
        string         $pattern,
        mixed          $callable,
        ?RouteMetadata $metadata = null
    ): RouteInterface {
        return new Route(
            $methods,
            $pattern,
            $callable,
            $this->responseFactory,
            $this->callableResolver,
            $metadata,
            $this->container,
            $this->defaultInvocationStrategy,
            $this->routeGroups,
            $this->routeCounter
        );
    }

    /**
     * Get cache key.
     *
     * @param array $mappingSources
     *
     * @return string
     */
    protected function getCacheKey(array $mappingSources): string
    {
        $key = \implode(
            '.',
            \array_map(
                function ($mappingSource): string {
                    if (!\is_array($mappingSource)) {
                        $mappingSource = [
                            'type' => DriverFactoryInterface::DRIVER_ANNOTATION,
                            'path' => $mappingSource,
                        ];
                    }

                    $path = \is_array($mappingSource['path'])
                        ? \implode('', $mappingSource['path'])
                        : $mappingSource['path'];

                    return $mappingSource['type'] . '.' . $path;
                },
                $mappingSources
            )
        );

        return $this->cachePrefix . \sha1($key);
    }
}