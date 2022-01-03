<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * @template T
 * @param class-string<T> $className
 * @return T
 */
function loadObject(string $className): mixed
{
    $container = require __DIR__ . '/../config/container.php';
    if ($container->has($className)) {
        return $container->get($className);
    }
    throw new InvalidArgumentException('Not found');
}

function handle(ServerRequestInterface $serverRequest): ResponseInterface
{
    $container = require __DIR__ . '/../config/container.php';
    /** @var Application $app */
    $app = $container->get(Application::class);
    $factory = $container->get(MiddlewareFactory::class);
    (require __DIR__ . '/../config/pipeline.php')($app, $factory, $container);
    (require __DIR__ . '/../config/routes.php')($app, $factory, $container);

    $response = $app->handle($serverRequest);
    $response->getBody()->rewind();
    return $response;
}
