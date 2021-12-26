<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Repository;

use EveryWorkflow\SalesOrderBundle\Entity\SalesOrderEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;

#[EntityRepositoryAttribute(documentClass: SalesOrderEntity::class, entityCode: 'sales_order')]
class SalesOrderRepository extends BaseEntityRepository implements SalesOrderRepositoryInterface
{
    // Something
}
