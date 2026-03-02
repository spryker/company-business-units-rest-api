<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitAttributesTransfer;

class CompanyBusinessUnitMapper implements CompanyBusinessUnitMapperInterface
{
    /**
     * @var array<\Spryker\Glue\CompanyBusinessUnitsRestApiExtension\Dependency\Plugin\CompanyBusinessUnitMapperPluginInterface>
     */
    protected $companyBusinessUnitMapperPlugins;

    /**
     * @param array<\Spryker\Glue\CompanyBusinessUnitsRestApiExtension\Dependency\Plugin\CompanyBusinessUnitMapperPluginInterface> $companyBusinessUnitMapperPlugins
     */
    public function __construct(array $companyBusinessUnitMapperPlugins)
    {
        $this->companyBusinessUnitMapperPlugins = $companyBusinessUnitMapperPlugins;
    }

    public function mapCompanyBusinessUnitTransferToRestCompanyBusinessUnitAttributesTransfer(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer
    ): RestCompanyBusinessUnitAttributesTransfer {
        $restCompanyBusinessUnitAttributesTransfer->fromArray($companyBusinessUnitTransfer->toArray(), true);

        return $this->executeCompanyBusinessUnitMapperPlugins(
            $companyBusinessUnitTransfer,
            $restCompanyBusinessUnitAttributesTransfer,
        );
    }

    protected function executeCompanyBusinessUnitMapperPlugins(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        RestCompanyBusinessUnitAttributesTransfer $restCompanyBusinessUnitAttributesTransfer
    ): RestCompanyBusinessUnitAttributesTransfer {
        foreach ($this->companyBusinessUnitMapperPlugins as $companyBusinessUnitMapperPlugin) {
            $restCompanyBusinessUnitAttributesTransfer = $companyBusinessUnitMapperPlugin->mapCompanyBusinessUnitTransferToRestCompanyBusinessUnitAttributesTransfer(
                $companyBusinessUnitTransfer,
                $restCompanyBusinessUnitAttributesTransfer,
            );
        }

        return $restCompanyBusinessUnitAttributesTransfer;
    }
}
