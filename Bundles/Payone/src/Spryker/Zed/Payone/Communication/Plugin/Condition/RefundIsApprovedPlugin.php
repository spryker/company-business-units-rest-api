<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Condition;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Payone\Business\PayoneFacade;
use Spryker\Zed\Payone\Communication\PayoneCommunicationFactory;

/**
 * @method PayoneFacade getFacade()
 * @method PayoneCommunicationFactory getCommunicationFactory()
 */
class RefundIsApprovedPlugin extends AbstractPlugin
{

    const NAME = 'RefundIsApprovedPlugin';

    /**
     * @param OrderTransfer $orderTransfer
     *
     * @return bool
     */
    protected function callFacade(OrderTransfer $orderTransfer)
    {
        return $this->getFacade()->isRefundApproved($orderTransfer);
    }

}
