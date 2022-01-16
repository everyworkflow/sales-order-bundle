<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SalesOrderBundle\Entity\SalesOrderEntityInterface;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveOrderController extends AbstractController
{
    protected SalesOrderRepositoryInterface $salesOrderRepository;

    public function __construct(SalesOrderRepositoryInterface $salesOrderRepository)
    {
        $this->salesOrderRepository = $salesOrderRepository;
    }

    #[EwRoute(
        path: "sales/order/{uuid}",
        name: 'sales.order.save',
        methods: 'POST',
        permissions: 'sales.order.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => []
                        ]
                    ]
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $uuid) {
            /** @var SalesOrderEntityInterface $item */
            $item = $this->salesOrderRepository->create($submitData);
        } else {
            $item = $this->salesOrderRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }
        $result = $this->salesOrderRepository->saveOne($item);

        if ($result instanceof InsertOneResult) {
            if ($result->getInsertedId()) {
                $item->setData('_id', $result->getInsertedId());
            }
        } elseif ($result instanceof UpdateResult) {
            if ($result->getUpsertedId()) {
                $item->setData('_id', $result->getUpsertedId());
            }
        }

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
