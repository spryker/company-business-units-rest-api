<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Mapper;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

/**
 * Flattens {@see CompanyBusinessUnitTransfer} into the storefront resource attribute array.
 * Keeps the same field surface as legacy `RestCompanyBusinessUnitAttributes`: name, email,
 * phone, externalUrl, bic, iban, defaultBillingAddress — plus the JSON:API `uuid` id.
 */
class CompanyBusinessUnitResourceMapper
{
    /**
     * @return array<string, mixed>
     */
    public function mapCompanyBusinessUnitTransferToResourceData(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): array {
        return [
            'uuid' => $companyBusinessUnitTransfer->getUuid(),
            'name' => $companyBusinessUnitTransfer->getName(),
            'email' => $companyBusinessUnitTransfer->getEmail(),
            'phone' => $companyBusinessUnitTransfer->getPhone(),
            'externalUrl' => $companyBusinessUnitTransfer->getExternalUrl(),
            'bic' => $companyBusinessUnitTransfer->getBic(),
            'iban' => $companyBusinessUnitTransfer->getIban(),
            'defaultBillingAddress' => $companyBusinessUnitTransfer->getDefaultBillingAddress(),
        ];
    }
}
