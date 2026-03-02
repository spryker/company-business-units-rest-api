<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Expander;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\QuoteRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class CompanyBusinessUnitByQuoteRequestResourceRelationshipExpander extends AbstractCompanyBusinessUnitResourceRelationshipExpander
{
    protected function findCompanyBusinessUnitTransferInPayload(RestResourceInterface $restResource): ?CompanyBusinessUnitTransfer
    {
        /**
         * @var \Generated\Shared\Transfer\QuoteRequestTransfer|null $payload
         */
        $payload = $restResource->getPayload();

        if ($payload === null || !($payload instanceof QuoteRequestTransfer)) {
            return null;
        }

        $companyUserTransfer = $payload->getCompanyUser();

        if ($companyUserTransfer === null || !$companyUserTransfer->getCompanyBusinessUnit()) {
            return null;
        }

        return $companyUserTransfer->getCompanyBusinessUnit();
    }
}
