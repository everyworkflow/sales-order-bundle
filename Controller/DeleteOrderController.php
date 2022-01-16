<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteOrderController extends AbstractController
{
    protected SalesOrderRepositoryInterface $salesOrderRepository;

    public function __construct(SalesOrderRepositoryInterface $salesOrderRepository)
    {
        $this->salesOrderRepository = $salesOrderRepository;
    }

    #[EwRoute(
        path: "sales/order/{uuid}",
        name: 'sales.order.delete',
        methods: 'DELETE',
        permissions: 'sales.order.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->salesOrderRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);
            return new JsonResponse(['detail' => 'ID: ' . $uuid . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
