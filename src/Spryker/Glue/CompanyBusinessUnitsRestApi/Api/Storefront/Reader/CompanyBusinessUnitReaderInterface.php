<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Reader;

use Generated\Shared\Transfer\CompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyBusinessUnitReaderInterface
{
    public function findCompanyBusinessUnitByUuid(string $uuid): ?CompanyBusinessUnitTransfer;

    public function getCompanyBusinessUnitCollectionByCompanyUserId(
        int $idCompanyUser,
    ): CompanyBusinessUnitCollectionTransfer;

    /**
     * @param list<int> $idCompanyBusinessUnits
     *
     * @return array<int, \Generated\Shared\Transfer\CompanyBusinessUnitTransfer>
     */
    public function getCompanyBusinessUnitTransfersIndexedByIdCompanyBusinessUnit(array $idCompanyBusinessUnits): array;
}
