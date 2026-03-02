<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Expander;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitAttributesTransfer;
use Spryker\Glue\CompanyBusinessUnitsRestApi\CompanyBusinessUnitsRestApiConfig;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

abstract class AbstractCompanyBusinessUnitResourceRelationshipExpander implements CompanyBusinessUnitResourceRelationshipExpanderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapperInterface
     */
    protected $companyBusinessUnitMapper;

    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyBusinessUnitMapperInterface $companyBusinessUnitMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyBusinessUnitMapper = $companyBusinessUnitMapper;
    }

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): array
    {
        foreach ($resources as $resource) {
            $companyBusinessUnitTransfer = $this->findCompanyBusinessUnitTransferInPayload($resource);
            if (!$companyBusinessUnitTransfer) {
                continue;
            }

            $resource->addRelationship(
                $this->createCompanyBusinessUnitResource($companyBusinessUnitTransfer),
            );
        }

        return $resources;
    }

    abstract protected function findCompanyBusinessUnitTransferInPayload(RestResourceInterface $restResource): ?CompanyBusinessUnitTransfer;

    protected function createCompanyBusinessUnitResource(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): RestResourceInterface {
        $restCompanyBusinessUnitAttributesTransfer = $this->companyBusinessUnitMapper
            ->mapCompanyBusinessUnitTransferToRestCompanyBusinessUnitAttributesTransfer(
                $companyBusinessUnitTransfer,
                new RestCompanyBusinessUnitAttributesTransfer(),
            );

        return $this->restResourceBuilder->createRestResource(
            CompanyBusinessUnitsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNITS,
            $companyBusinessUnitTransfer->getUuid(),
            $restCompanyBusinessUnitAttributesTransfer,
        );
    }
}
