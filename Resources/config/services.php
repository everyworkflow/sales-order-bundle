<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\SalesOrderBundle\DataGrid\SalesOrderDataGrid;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepository;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\SalesOrderBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_sales_order_grid_config', DataGridConfig::class);
    $services->set('ew_sales_order_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(SalesOrderRepository::class))
        ->arg('$dataGridConfig', service('ew_sales_order_grid_config'));
    $services->set(SalesOrderDataGrid::class)
        ->arg('$source', service('ew_sales_order_grid_source'))
        ->arg('$dataGridConfig', service('ew_sales_order_grid_config'));
};
