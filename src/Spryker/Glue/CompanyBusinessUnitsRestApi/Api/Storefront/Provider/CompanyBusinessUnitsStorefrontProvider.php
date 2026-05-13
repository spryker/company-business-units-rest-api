<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Provider;

use Generated\Api\Storefront\CompanyBusinessUnitsStorefrontResource;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Client\CompanyBusinessUnit\CompanyBusinessUnitClientInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Exception\CompanyBusinessUnitsExceptionFactory;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Mapper\CompanyBusinessUnitResourceMapper;

/**
 * Partial API Platform migration: only `GET /company-business-units/{uuid}` is served from here.
 * Mutating operations and the collection endpoint remain on the legacy Glue REST stack.
 *
 * Ownership rule mirrors the legacy `CompanyBusinessUnitReader::isCurrentCompanyUserInCompany`:
 * the business unit must belong to the same `fkCompany` as the authenticated company user, else
 * the response is the legacy-equivalent 404 (a 403 would leak the existence of the resource).
 */
class CompanyBusinessUnitsStorefrontProvider extends AbstractStorefrontProvider
{
    public function __construct(
        protected CompanyBusinessUnitClientInterface $companyBusinessUnitClient,
        protected CompanyBusinessUnitResourceMapper $companyBusinessUnitResourceMapper,
        protected CompanyBusinessUnitsExceptionFactory $exceptionFactory,
    ) {
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function provideItem(): ?object
    {
        $uuid = $this->getUriVariables()['uuid'] ?? null;

        if ($uuid === null || $uuid === '') {
            throw $this->exceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        $companyBusinessUnitResponseTransfer = $this->companyBusinessUnitClient->findCompanyBusinessUnitByUuid(
            (new CompanyBusinessUnitTransfer())->setUuid($uuid),
        );

        if (!$companyBusinessUnitResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        $companyBusinessUnitTransfer = $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransferOrFail();

        if (!$this->isAuthenticatedCustomerInSameCompany($companyBusinessUnitTransfer)) {
            throw $this->exceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        return CompanyBusinessUnitsStorefrontResource::fromArray(
            $this->companyBusinessUnitResourceMapper->mapCompanyBusinessUnitTransferToResourceData($companyBusinessUnitTransfer),
        );
    }

    /**
     * Ownership check — only members of the same company can read a business unit. Customer is
     * known to be present at this point (resource is `ROLE_CUSTOMER`-gated), but the
     * `CompanyUserTransfer` is optional: a logged-in customer who is not a company user is
     * treated the same as a stranger to the company → 404.
     */
    protected function isAuthenticatedCustomerInSameCompany(CompanyBusinessUnitTransfer $companyBusinessUnitTransfer): bool
    {
        if (!$this->hasCustomer()) {
            return false;
        }

        $companyUserTransfer = $this->getCustomer()->getCompanyUserTransfer();

        if ($companyUserTransfer === null) {
            return false;
        }

        $idCompany = $companyUserTransfer->getFkCompany();

        return $idCompany !== null && $idCompany === $companyBusinessUnitTransfer->getFkCompany();
    }
}
