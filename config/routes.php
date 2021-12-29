<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\GetOrderAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\PlaceOrderAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\SimulateFreightAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\ValidateCouponAction;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->route('/order[/{code}]', GetOrderAction::class, ['GET']);
    $app->route('/order', PlaceOrderAction::class, ['POST']);
    $app->route('/simulate-freight', SimulateFreightAction::class, ['POST']);
    $app->route('/validate-coupon/{code}', ValidateCouponAction::class, ['POST']);
};
