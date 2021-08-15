<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
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

    /**
     * @EWFRoute(
     *     admin_api_path="sales/order/{uuid}",
     *     defaults={"uuid"="create"},
     *     name="admin.sales.order.save",
     *     methods="POST"
     * )
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $uuid) {
            /** @var SalesOrderEntityInterface $item */
            $item = $this->salesOrderRepository->getNewEntity($submitData);
        } else {
            $item = $this->salesOrderRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }
        $result = $this->salesOrderRepository->saveEntity($item);

        if ($result instanceof InsertOneResult) {
            if ($result->getInsertedId()) {
                $item->setData('_id', $result->getInsertedId());
            }
        } elseif ($result instanceof UpdateResult) {
            if ($result->getUpsertedId()) {
                $item->setData('_id', $result->getUpsertedId());
            }
        }

        return (new JsonResponse())->setData([
            'message' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
