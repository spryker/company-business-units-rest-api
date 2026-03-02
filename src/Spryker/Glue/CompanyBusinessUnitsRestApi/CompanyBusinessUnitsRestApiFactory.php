<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi;

use Spryker\Glue\CompanyBusinessUnitsRestApi\Dependency\Client\CompanyBusinessUnitsRestApiToCompanyBusinessUnitClientInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Expander\CompanyBusinessUnitByQuoteRequestResourceRelationshipExpander;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Expander\CompanyBusinessUnitResourceRelationshipExpander;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Expander\CompanyBusinessUnitResourceRelationshipExpanderInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapper;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Mapper\CompanyBusinessUnitMapperInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Reader\CompanyBusinessUnitReader;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\Reader\CompanyBusinessUnitReaderInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder\CompanyBusinessUnitRestResponseBuilder;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\CompanyBusinessUnit\RestResponseBuilder\CompanyBusinessUnitRestResponseBuilderInterface;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\Customer\CustomerExpander;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Processor\Customer\CustomerExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyBusinessUnitsRestApiFactory extends AbstractFactory
{
    public function createCompanyBusinessUnitResourceRelationshipExpander(): CompanyBusinessUnitResourceRelationshipExpanderInterface
    {
        return new CompanyBusinessUnitResourceRelationshipExpander(
            $this->getResourceBuilder(),
            $this->createCompanyBusinessUnitMapper(),
        );
    }

    public function createCompanyBusinessUnitByQuoteRequestResourceRelationshipExpander(): CompanyBusinessUnitResourceRelationshipExpanderInterface
    {
        return new CompanyBusinessUnitByQuoteRequestResourceRelationshipExpander(
            $this->getResourceBuilder(),
            $this->createCompanyBusinessUnitMapper(),
        );
    }

    public function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader(
            $this->createCompanyBusinessUnitMapper(),
            $this->getCompanyBusinessUnitClient(),
            $this->createCompanyBusinessUnitRestResponseBuilder(),
        );
    }

    public function createCompanyBusinessUnitMapper(): CompanyBusinessUnitMapperInterface
    {
        return new CompanyBusinessUnitMapper(
            $this->getCompanyBusinessUnitMapperPlugins(),
        );
    }

    public function createCustomerExpander(): CustomerExpanderInterface
    {
        return new CustomerExpander();
    }

    public function createCompanyBusinessUnitRestResponseBuilder(): CompanyBusinessUnitRestResponseBuilderInterface
    {
        return new CompanyBusinessUnitRestResponseBuilder($this->getResourceBuilder());
    }

    public function getCompanyBusinessUnitClient(): CompanyBusinessUnitsRestApiToCompanyBusinessUnitClientInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsRestApiDependencyProvider::CLIENT_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return array<\Spryker\Glue\CompanyBusinessUnitsRestApiExtension\Dependency\Plugin\CompanyBusinessUnitMapperPluginInterface>
     */
    public function getCompanyBusinessUnitMapperPlugins(): array
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsRestApiDependencyProvider::PLUGINS_COMPANY_BUSINESS_UNIT_MAPPER);
    }
}
