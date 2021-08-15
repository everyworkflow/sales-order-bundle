<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Migration;

use EveryWorkflow\SalesOrderBundle\Entity\SalesOrderEntity;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;
use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_10_00_00_00_SalesOrder_Migration implements MigrationInterface
{
    protected EntityRepositoryInterface $entityRepository;
    protected AttributeRepositoryInterface $attributeRepository;
    protected SalesOrderRepositoryInterface $salesOrderRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        AttributeRepositoryInterface $attributeRepository,
        SalesOrderRepositoryInterface $salesOrderRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->attributeRepository = $attributeRepository;
        $this->salesOrderRepository = $salesOrderRepository;
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $productEntity */
        $orderEntity = $this->entityRepository->getDocumentFactory()
            ->create(EntityDocument::class);
        $orderEntity
            ->setName('Sales order')
            ->setCode($this->salesOrderRepository->getEntityCode())
            ->setClass(SalesOrderEntity::class)
            ->setStatus(SalesOrderEntity::STATUS_ENABLE);
        $this->entityRepository->save($orderEntity);

        $attributeData = [
            [
                'code' => 'email',
                'name' => 'Email',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'firstname',
                'name' => 'Firstname',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'lastname',
                'name' => 'Lastname',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'customer_id',
                'name' => 'Customer ID',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['entity_code'] = $this->salesOrderRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->getDocumentFactory()
                ->createAttribute($item);
            $this->attributeRepository->save($attribute);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->salesOrderRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->salesOrderRepository->getEntityCode());
        $this->salesOrderRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
