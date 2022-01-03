<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Item\ItemResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order\OrderResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\SimulateFreight\SimulateFreightResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ValidateCoupon\ValidateCouponResource;

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
    $app->post('/rest/v1/simulate-freight', [SimulateFreightResource::class], 'post.rest.v1.simulate-freight');
    $app->post('/rest/v1/validate-coupon/{code}', [ValidateCouponResource::class], 'post.rest.v1.validate-coupon.code');

    $app->post('/rest/v1/order', [OrderResource::class], 'post.rest.v1.order');
    $app->get('/rest/v1/order', [OrderResource::class], 'get.rest.v1.order');
    $app->get('/rest/v1/order/{code}', [OrderResource::class], 'get.rest.v1.order.code');

    $app->get('/rest/v1/item', [ItemResource::class], 'get.rest.v1.item');
    $app->get('/rest/v1/item/{id}', [ItemResource::class], 'get.rest.v1.item.id');
};
