<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\CompanyBusinessUnitsRestApi\CompanyBusinessUnitsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CompanyBusinessUnitRestResponseBuilder implements CompanyBusinessUnitRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    public function __construct(RestResourceBuilderInterface $restResourceBuilder)
    {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    public function createCompanyBusinessUnitRestResponse(
        string $companyBusinessUnitUuid,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer,
        ?CompanyBusinessUnitTransfer $companyBusinessUnitTransfer = null
    ): RestResponseInterface {
        $companyBusinessUnitRestResource = $this->createCompanyBusinessUnitRestResource(
            $companyBusinessUnitUuid,
            $restCompanyBusinessUnitAttributesTransfer,
            $companyBusinessUnitTransfer,
        );

        return $this->restResourceBuilder->createRestResponse()
            ->addResource($companyBusinessUnitRestResource);
    }

    public function createCompanyBusinessUnitRestResource(
        string $companyBusinessUnitUuid,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer,
        ?CompanyBusinessUnitTransfer $companyBusinessUnitTransfer = null
    ): RestResourceInterface {
        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyBusinessUnitsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNITS,
            $companyBusinessUnitUuid,
            $restCompanyBusinessUnitAttributesTransfer,
        );

        if (!$companyBusinessUnitTransfer) {
            return $restResource;
        }

        $restResource->setPayload($companyBusinessUnitTransfer);

        return $restResource;
    }

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $companyBusinessUnitRestResources
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyBusinessUnitCollectionRestResponse(array $companyBusinessUnitRestResources): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($companyBusinessUnitRestResources as $companyBusinessUnitRestResource) {
            $restResponse->addResource($companyBusinessUnitRestResource);
        }

        return $restResponse;
    }

    public function createCompanyBusinessUnitNotFoundError(): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyBusinessUnitsRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_NOT_FOUND)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_COMPANY_BUSINESS_UNIT_NOT_FOUND);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorTransfer);
    }

    public function createResourceNotImplementedError(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_NOT_IMPLEMENTED)
            ->setDetail(CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_RESOURCE_NOT_IMPLEMENTED);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    public function createCompanyUserNotSelectedError(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setCode(CompanyBusinessUnitsRestApiConfig::RESPONSE_CODE_COMPANY_USER_NOT_SELECTED)
            ->setDetail(CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_COMPANY_USER_NOT_SELECTED);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }
}
