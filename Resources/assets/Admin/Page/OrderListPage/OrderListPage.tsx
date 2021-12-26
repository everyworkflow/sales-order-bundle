/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, { useContext, useEffect } from 'react';
import PanelContext from "@EveryWorkflow/PanelBundle/Context/PanelContext";
import { ACTION_SET_PAGE_TITLE } from "@EveryWorkflow/PanelBundle/Reducer/PanelReducer";
import DataGridComponent from "@EveryWorkflow/DataGridBundle/Component/DataGridComponent";
import { DATA_GRID_TYPE_PAGE } from "@EveryWorkflow/DataGridBundle/Component/DataGridComponent/DataGridComponent";
import { useLocation } from "react-router-dom";

const OrderListPage = () => {
    const { dispatch: panelDispatch } = useContext(PanelContext);
    const location = useLocation();

    useEffect(() => {
        panelDispatch({ type: ACTION_SET_PAGE_TITLE, payload: 'Sales order' });
    }, [panelDispatch]);

    return (
        <>
            <DataGridComponent
                dataGridUrl={'/sales/order' + location.search}
                dataGridType={DATA_GRID_TYPE_PAGE}
            />
        </>
    );
};

export default OrderListPage;
