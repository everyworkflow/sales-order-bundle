<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
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

    /**
     * @EWFRoute(
     *     admin_api_path="sales/order",
     *     name="admin.sales.order",
     *     priority=10,
     *     methods="GET"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->salesOrderDataGrid->setFromRequest($request);
        return (new JsonResponse())->setData($dataGrid->toArray());
    }
}
