<?php declare(strict_types=1);

namespace Ares\Framework\Strategy;

use Ares\Framework\Response\Handler\ResponseTypeHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RequestHandlerInvocationStrategyInterface;

/**
 * PSR-15 RequestHandler invocation strategy.
 */
class RequestHandler implements RequestHandlerInvocationStrategyInterface
{
    use ResponseTypeStrategyTrait;

    /**
     * @var bool
     */
    protected $appendRouteArguments;

    /**
     * RequestHandler constructor.
     *
     * @param array<string, string|ResponseTypeHandler> $responseHandlers
     * @param ResponseFactoryInterface                  $responseFactory
     * @param ContainerInterface|null                   $container
     * @param bool                                      $appendRouteArguments
     */
    public function __construct(
        array $responseHandlers,
        ResponseFactoryInterface $responseFactory,
        ?ContainerInterface $container = null,
        bool $appendRouteArguments = false
    ) {
        $this->setResponseHandlers($responseHandlers);

        $this->responseFactory = $responseFactory;
        $this->container = $container;
        $this->appendRouteArguments = $appendRouteArguments;
    }

    /**
     * Invoke a route callable that implements RequestHandlerInterface.
     *
     * @param callable               $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param mixed[]                $routeArguments
     *
     * @return ResponseInterface
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
        if ($this->appendRouteArguments) {
            foreach ($routeArguments as $argument => $value) {
                $request = $request->withAttribute($argument, $value);
            }
        }

        return $this->handleResponse($callable($request));
    }
}