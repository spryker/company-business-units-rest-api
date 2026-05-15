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
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Exception\CompanyBusinessUnitsExceptionFactory;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Mapper\CompanyBusinessUnitsResourceMapperInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Reader\CompanyBusinessUnitReaderInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CompanyBusinessUnitsStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string KEY_UUID = 'uuid';

    protected const string OPERATION_NAME_GET_COMPANY_BUSINESS_UNITS_MINE = 'getCompanyBusinessUnitsMine';

    public function __construct(
        protected CompanyBusinessUnitReaderInterface $companyBusinessUnitReader,
        protected CompanyBusinessUnitsExceptionFactory $companyBusinessUnitsExceptionFactory,
        protected CompanyBusinessUnitsResourceMapperInterface $companyBusinessUnitsResourceMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    protected function provideItem(): ?object
    {
        if (!$this->hasCustomer()) {
            throw new AccessDeniedException();
        }

        return $this->provideCompanyBusinessUnitByUuid(
            (string)$this->getUriVariable(static::KEY_UUID),
        );
    }

    protected function provideCollection(): array
    {
        if ($this->getOperation()->getName() !== static::OPERATION_NAME_GET_COMPANY_BUSINESS_UNITS_MINE) {
            throw $this->companyBusinessUnitsExceptionFactory->createResourceNotImplementedException();
        }

        if (!$this->hasCustomer()) {
            throw new AccessDeniedException();
        }

        return $this->provideCurrentUserCompanyBusinessUnits();
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return array<\Generated\Api\Storefront\CompanyBusinessUnitsStorefrontResource>
     */
    protected function provideCurrentUserCompanyBusinessUnits(): array
    {
        $idCompanyUser = $this->getCustomer()->getCompanyUserTransfer()?->getIdCompanyUser();

        if ($idCompanyUser === null) {
            throw $this->companyBusinessUnitsExceptionFactory->createCompanyUserNotSelectedException();
        }

        $companyBusinessUnitCollectionTransfer = $this->companyBusinessUnitReader
            ->getCompanyBusinessUnitCollectionByCompanyUserId($idCompanyUser);

        if ($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits()->count() === 0) {
            throw $this->companyBusinessUnitsExceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        $resources = [];

        foreach ($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits() as $companyBusinessUnitTransfer) {
            $resources[] = $this->denormalizeToResource($companyBusinessUnitTransfer);
        }

        return $resources;
    }

    protected function provideCompanyBusinessUnitByUuid(string $uuid): CompanyBusinessUnitsStorefrontResource
    {
        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->findCompanyBusinessUnitByUuid($uuid);

        if ($companyBusinessUnitTransfer === null) {
            throw $this->companyBusinessUnitsExceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        $idCurrentCompany = $this->getCustomer()->getCompanyUserTransfer()?->getFkCompany();

        if ($idCurrentCompany === null || $idCurrentCompany !== $companyBusinessUnitTransfer->getFkCompany()) {
            throw $this->companyBusinessUnitsExceptionFactory->createCompanyBusinessUnitNotFoundException();
        }

        return $this->denormalizeToResource($companyBusinessUnitTransfer);
    }

    protected function denormalizeToResource(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitsStorefrontResource {
        return $this->serializer->denormalize(
            $this->companyBusinessUnitsResourceMapper->mapCompanyBusinessUnitTransferToResourceData($companyBusinessUnitTransfer),
            CompanyBusinessUnitsStorefrontResource::class,
        );
    }
}
