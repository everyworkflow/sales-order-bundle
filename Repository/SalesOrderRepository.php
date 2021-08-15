<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Repository;

use EveryWorkflow\CoreBundle\Annotation\RepoDocument;
use EveryWorkflow\SalesOrderBundle\Entity\SalesOrderEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;

/**
 * @RepoDocument(doc_name=SalesOrderEntity::class)
 */
class SalesOrderRepository extends BaseEntityRepository implements SalesOrderRepositoryInterface
{
    protected string $collectionName = 'sales_order_entity_collection';
    protected array $indexNames = ['_id'];
    protected string $entityCode = 'sales_order';
}
