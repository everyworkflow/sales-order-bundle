<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetOrderController extends AbstractController
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
     *     name="admin.sales.order.view",
     *     methods="GET"
     * )
     * @throws \Exception
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = [];

        if ($uuid !== 'create') {
            $item = $this->salesOrderRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        $data['data_form'] = $this->salesOrderRepository->getForm()->toArray();

        return (new JsonResponse())->setData($data);
    }
}
