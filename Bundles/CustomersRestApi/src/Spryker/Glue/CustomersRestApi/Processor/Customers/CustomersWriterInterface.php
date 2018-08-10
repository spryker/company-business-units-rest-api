<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CustomersRestApi\Processor\Customers;

use Generated\Shared\Transfer\RestCustomersAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CustomersWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomersAttributesTransfer $restCustomerTransfer
     *
     * @return mixed
     */
    public function updateCustomer(RestCustomersAttributesTransfer $restCustomerTransfer): RestResponseInterface;
}
