<?php

use Laminas\Hydrator\ObjectPropertyHydrator;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItemOutput;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrderOutput;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Item\GetItemOutputCollection;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order\GetOrderOutputCollection;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order\PostOrderOutput;

return [
    MetadataMap::class => [
        [
            'route' => 'get.rest.v1.order.code',
            'resource_identifier' => 'code',
            'resource_class' => PostOrderOutput::class,
            '__class__' => RouteBasedResourceMetadata::class,
            'extractor' => ObjectPropertyHydrator::class,
        ],
        [
            'route' => 'get.rest.v1.order.code',
            'resource_identifier' => 'code',
            'resource_class' => GetOrderOutput::class,
            '__class__' => RouteBasedResourceMetadata::class,
            'extractor' => ObjectPropertyHydrator::class,
        ],
        [
            'collection_relation' => 'get.rest.v1.order.code',
            'route' => 'get.rest.v1.order',
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => GetOrderOutputCollection::class,
        ],

        [
            'route' => 'get.rest.v1.item.id',
            'resource_identifier' => 'id',
            'resource_class' => GetItemOutput::class,
            '__class__' => RouteBasedResourceMetadata::class,
            'extractor' => ObjectPropertyHydrator::class,
        ],
        [
            'collection_relation' => 'get.rest.v1.item.id',
            'route' => 'get.rest.v1.item',
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => GetItemOutputCollection::class,
        ],
    ]
];
