<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CompanyBusinessUnitRestResponseBuilderInterface
{
    public function createCompanyBusinessUnitRestResponse(
        string $companyBusinessUnitUuid,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer,
        ?CompanyBusinessUnitTransfer $companyBusinessUnitTransfer = null
    ): RestResponseInterface;

    public function createCompanyBusinessUnitRestResource(
        string $companyBusinessUnitUuid,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer,
        ?CompanyBusinessUnitTransfer $companyBusinessUnitTransfer = null
    ): RestResourceInterface;

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $companyBusinessUnitRestResources
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyBusinessUnitCollectionRestResponse(array $companyBusinessUnitRestResources): RestResponseInterface;

    public function createCompanyBusinessUnitNotFoundError(): RestResponseInterface;

    public function createResourceNotImplementedError(): RestResponseInterface;

    public function createCompanyUserNotSelectedError(): RestResponseInterface;
}
