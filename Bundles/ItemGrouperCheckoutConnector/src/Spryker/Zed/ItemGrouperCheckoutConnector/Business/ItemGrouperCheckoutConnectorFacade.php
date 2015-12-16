<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\ItemGrouperCheckoutConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Generated\Shared\Transfer\GroupableContainerTransfer;

/**
 * @method ItemGrouperCheckoutConnectorBusinessFactory getBusinessFactory()
 */
class ItemGrouperCheckoutConnectorFacade extends AbstractFacade
{

    /**
     * @param GroupableContainerTransfer $orderItems
     *
     * @return GroupableContainerTransfer
     */
    public function groupOrderItems(GroupableContainerTransfer $orderItems)
    {
        return $this->getBusinessFactory()->createItemGrouperFacade()->groupItemsByKey($orderItems);
    }

}
