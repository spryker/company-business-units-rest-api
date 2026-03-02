<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Reader;

use Generated\Shared\Transfer\CompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitAttributesTransfer;
use Spryker\Glue\CompanyBusinessUnitsRestApi\CompanyBusinessUnitsRestApiConfig;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Dependency\Client\CompanyBusinessUnitsRestApiToCompanyBusinessUnitClientInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapperInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder\CompanyBusinessUnitRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyBusinessUnitReader implements CompanyBusinessUnitReaderInterface
{
    /**
     * @var \Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapperInterface
     */
    protected $companyBusinessUnitMapper;

    /**
     * @var \Spryker\Glue\CompanyBusinessUnitsRestApi\Dependency\Client\CompanyBusinessUnitsRestApiToCompanyBusinessUnitClientInterface
     */
    protected $companyBusinessUnitClient;

    /**
     * @var \Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder\CompanyBusinessUnitRestResponseBuilderInterface
     */
    protected $companyBusinessUnitRestResponseBuilder;

    public function __construct(
        CompanyBusinessUnitMapperInterface $companyBusinessUnitMapperInterface,
        CompanyBusinessUnitsRestApiToCompanyBusinessUnitClientInterface $companyBusinessUnitClient,
        CompanyBusinessUnitRestResponseBuilderInterface $companyBusinessUnitRestResponseBuilder
    ) {
        $this->companyBusinessUnitMapper = $companyBusinessUnitMapperInterface;
        $this->companyBusinessUnitClient = $companyBusinessUnitClient;
        $this->companyBusinessUnitRestResponseBuilder = $companyBusinessUnitRestResponseBuilder;
    }

    public function getCurrentUserCompanyBusinessUnit(RestRequestInterface $restRequest): RestResponseInterface
    {
        if ($this->isResourceIdentifierCurrentUser($restRequest->getResource()->getId())) {
            return $this->getCurrentUserCompanyBusinessUnits($restRequest);
        }

        return $this->getCurrentUserCompanyBusinessUnitByUuid($restRequest);
    }

    protected function getCurrentUserCompanyBusinessUnits(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()->getIdCompany()) {
            return $this->companyBusinessUnitRestResponseBuilder->createCompanyUserNotSelectedError();
        }

        $companyBusinessUnitCollection = $this->companyBusinessUnitClient->getCompanyBusinessUnitCollection(
            (new CompanyBusinessUnitCriteriaFilterTransfer())->setIdCompanyUser($restRequest->getRestUser()->getIdCompanyUser()),
        );

        if (!$companyBusinessUnitCollection->getCompanyBusinessUnits()->count()) {
            return $this->companyBusinessUnitRestResponseBuilder->createCompanyBusinessUnitNotFoundError();
        }

        return $this->createCompanyBusinessUnitCollectionResponse($companyBusinessUnitCollection);
    }

    protected function getCurrentUserCompanyBusinessUnitByUuid(RestRequestInterface $restRequest): RestResponseInterface
    {
        $companyBusinessUnitResponseTransfer = $this->companyBusinessUnitClient->findCompanyBusinessUnitByUuid(
            (new CompanyBusinessUnitTransfer())->setUuid($restRequest->getResource()->getId()),
        );

        if (
            !$companyBusinessUnitResponseTransfer->getIsSuccessful()
            || !$this->isCurrentCompanyUserInCompany($restRequest, $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransfer())
        ) {
            return $this->companyBusinessUnitRestResponseBuilder->createCompanyBusinessUnitNotFoundError();
        }

        $restCompanyBusinessUnitAttributesTransfer = $this->companyBusinessUnitMapper->mapCompanyBusinessUnitTransferToRestCompanyBusinessUnitAttributesTransfer(
            $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransfer(),
            new RestCompanyBusinessUnitAttributesTransfer(),
        );

        return $this->companyBusinessUnitRestResponseBuilder->createCompanyBusinessUnitRestResponse(
            $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransfer()->getUuid(),
            $restCompanyBusinessUnitAttributesTransfer,
            $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransfer(),
        );
    }

    protected function isResourceIdentifierCurrentUser(string $resourceIdentifier): bool
    {
        return $resourceIdentifier === CompanyBusinessUnitsRestApiConfig::COLLECTION_IDENTIFIER_CURRENT_USER;
    }

    protected function createCompanyBusinessUnitCollectionResponse(
        CompanyBusinessUnitCollectionTransfer $companyBusinessUnitCollectionTransfer
    ): RestResponseInterface {
        $companyBusinessUnitRestResources = [];

        foreach ($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits() as $companyBusinessUnitTransfer) {
            $restCompanyBusinessUnitAttributesTransfer = $this->companyBusinessUnitMapper->mapCompanyBusinessUnitTransferToRestCompanyBusinessUnitAttributesTransfer(
                $companyBusinessUnitTransfer,
                new RestCompanyBusinessUnitAttributesTransfer(),
            );
            $companyBusinessUnitRestResources[] = $this->companyBusinessUnitRestResponseBuilder->createCompanyBusinessUnitRestResource(
                $companyBusinessUnitTransfer->getUuid(),
                $restCompanyBusinessUnitAttributesTransfer,
                $companyBusinessUnitTransfer,
            );
        }

        return $this->companyBusinessUnitRestResponseBuilder
            ->createCompanyBusinessUnitCollectionRestResponse($companyBusinessUnitRestResources);
    }

    protected function isCurrentCompanyUserInCompany(
        RestRequestInterface $restRequest,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): bool {
        return $restRequest->getRestUser()
            && $restRequest->getRestUser()->getIdCompany()
            && $restRequest->getRestUser()->getIdCompany() === $companyBusinessUnitTransfer->getFkCompany();
    }
}
