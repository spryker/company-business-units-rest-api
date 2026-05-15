<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Relationship;

use Generated\Api\Storefront\CompanyBusinessUnitsStorefrontResource;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\ApiPlatform\Relationship\PerItemRelationshipResolverInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Mapper\CompanyBusinessUnitsResourceMapperInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Reader\CompanyBusinessUnitReaderInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

class CompanyBusinessUnitsRelationshipResolver implements PerItemRelationshipResolverInterface
{
    public function __construct(
        protected CompanyBusinessUnitReaderInterface $companyBusinessUnitReader,
        protected CompanyBusinessUnitsResourceMapperInterface $companyBusinessUnitsResourceMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * @param array<object> $parentResources
     * @param array<string, mixed> $context
     *
     * @return array<object>
     */
    public function resolve(array $parentResources, array $context): array
    {
        $allResources = [];

        foreach ($this->resolvePerItem($parentResources, $context) as $resources) {
            $allResources = array_merge($allResources, $resources);
        }

        return $allResources;
    }

    /**
     * @param array<object> $parentResources
     * @param array<string, mixed> $context
     *
     * @return array<string, array<object>>
     */
    public function resolvePerItem(array $parentResources, array $context): array
    {
        $idCompanyBusinessUnitsIndexedByParentResourceUuid = $this->getIdCompanyBusinessUnitsIndexedByParentResourceUuid($parentResources);

        if ($idCompanyBusinessUnitsIndexedByParentResourceUuid === []) {
            return [];
        }

        $companyBusinessUnitsIndexedByIdCompanyBusinessUnit = $this->companyBusinessUnitReader
            ->getCompanyBusinessUnitTransfersIndexedByIdCompanyBusinessUnit(array_values($idCompanyBusinessUnitsIndexedByParentResourceUuid));

        $result = [];

        foreach ($idCompanyBusinessUnitsIndexedByParentResourceUuid as $parentResourceUuid => $idCompanyBusinessUnit) {
            $companyBusinessUnitTransfer = $companyBusinessUnitsIndexedByIdCompanyBusinessUnit[$idCompanyBusinessUnit] ?? null;

            $result[$parentResourceUuid] = $companyBusinessUnitTransfer !== null
                ? [$this->denormalizeToCompanyBusinessUnitResource($companyBusinessUnitTransfer)]
                : [];
        }

        return $result;
    }

    /**
     * @param array<object> $parentResources
     *
     * @return array<string, int>
     */
    protected function getIdCompanyBusinessUnitsIndexedByParentResourceUuid(array $parentResources): array
    {
        $idCompanyBusinessUnitsIndexedByParentResourceUuid = [];

        foreach ($parentResources as $parentResource) {
            $parentResourceUuid = $parentResource->uuid ?? null;
            $idCompanyBusinessUnit = $parentResource->idCompanyBusinessUnit ?? null;

            if ($parentResourceUuid === null || $idCompanyBusinessUnit === null) {
                continue;
            }

            $idCompanyBusinessUnitsIndexedByParentResourceUuid[$parentResourceUuid] = $idCompanyBusinessUnit;
        }

        return $idCompanyBusinessUnitsIndexedByParentResourceUuid;
    }

    protected function denormalizeToCompanyBusinessUnitResource(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitsStorefrontResource {
        return $this->serializer->denormalize(
            $this->companyBusinessUnitsResourceMapper->mapCompanyBusinessUnitTransferToResourceData($companyBusinessUnitTransfer),
            CompanyBusinessUnitsStorefrontResource::class,
        );
    }
}
