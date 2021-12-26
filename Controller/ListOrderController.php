<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SalesOrderBundle\DataGrid\SalesOrderDataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListOrderController extends AbstractController
{
    protected SalesOrderDataGridInterface $salesOrderDataGrid;

    public function __construct(SalesOrderDataGridInterface $salesOrderDataGrid)
    {
        $this->salesOrderDataGrid = $salesOrderDataGrid;
    }

    #[EwRoute(
        path: "sales/order",
        name: 'sales.order',
        priority: 10,
        methods: 'GET',
        permissions: 'sales.order.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->salesOrderDataGrid->setFromRequest($request);
        return new JsonResponse($dataGrid->toArray());
    }
}
