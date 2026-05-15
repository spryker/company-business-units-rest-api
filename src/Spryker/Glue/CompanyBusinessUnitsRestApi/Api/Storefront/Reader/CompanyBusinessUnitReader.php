<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Reader;

use Generated\Shared\Transfer\CompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Client\CompanyBusinessUnit\CompanyBusinessUnitClientInterface;

class CompanyBusinessUnitReader implements CompanyBusinessUnitReaderInterface
{
    public function __construct(protected CompanyBusinessUnitClientInterface $companyBusinessUnitClient)
    {
    }

    public function findCompanyBusinessUnitByUuid(string $uuid): ?CompanyBusinessUnitTransfer
    {
        $companyBusinessUnitResponseTransfer = $this->companyBusinessUnitClient->findCompanyBusinessUnitByUuid(
            (new CompanyBusinessUnitTransfer())->setUuid($uuid),
        );

        if (!$companyBusinessUnitResponseTransfer->getIsSuccessful()) {
            return null;
        }

        return $companyBusinessUnitResponseTransfer->getCompanyBusinessUnitTransfer();
    }

    public function getCompanyBusinessUnitCollectionByCompanyUserId(
        int $idCompanyUser,
    ): CompanyBusinessUnitCollectionTransfer {
        return $this->companyBusinessUnitClient->getCompanyBusinessUnitCollection(
            (new CompanyBusinessUnitCriteriaFilterTransfer())->setIdCompanyUser($idCompanyUser),
        );
    }

    /**
     * @param list<int> $idCompanyBusinessUnits
     *
     * @return array<int, \Generated\Shared\Transfer\CompanyBusinessUnitTransfer>
     */
    public function getCompanyBusinessUnitTransfersIndexedByIdCompanyBusinessUnit(array $idCompanyBusinessUnits): array
    {
        $companyBusinessUnitCollectionTransfer = $this->companyBusinessUnitClient->getCompanyBusinessUnitCollection(
            (new CompanyBusinessUnitCriteriaFilterTransfer())->setCompanyBusinessUnitIds($idCompanyBusinessUnits),
        );

        $companyBusinessUnitTransfersIndexedById = [];

        foreach ($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits() as $companyBusinessUnitTransfer) {
            $idCompanyBusinessUnit = $companyBusinessUnitTransfer->getIdCompanyBusinessUnit();

            if ($idCompanyBusinessUnit === null) {
                continue;
            }

            $companyBusinessUnitTransfersIndexedById[$idCompanyBusinessUnit] = $companyBusinessUnitTransfer;
        }

        return $companyBusinessUnitTransfersIndexedById;
    }
}
