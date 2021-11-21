<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle;

use EveryWorkflow\SalesOrderBundle\DependencyInjection\SalesOrderExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowSalesOrderBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SalesOrderExtension();
    }
}
