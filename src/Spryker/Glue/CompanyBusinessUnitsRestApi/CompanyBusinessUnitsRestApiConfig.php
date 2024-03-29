<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CompanyBusinessUnitsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_COMPANY_BUSINESS_UNITS = 'company-business-units';

    /**
     * @var string
     */
    public const CONTROLLER_RESOURCE_COMPANY_BUSINESS_UNITS = 'company-business-units-resource';

    /**
     * @deprecated Will be removed with next major release.
     *
     * @var string
     */
    public const ACTION_COMPANY_BUSINESS_UNITS_GET = 'get';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_BUSINESS_UNIT_NOT_FOUND = '1901';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_COMPANY_BUSINESS_UNIT_NOT_FOUND = 'Company business unit not found.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_USER_NOT_SELECTED = '1903';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_COMPANY_USER_NOT_SELECTED = 'Current company user is not set. You need to select the current company user with /company-user-access-tokens in order to access the resource collection.';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_RESOURCE_NOT_IMPLEMENTED = 'Endpoint is not implemented.';

    /**
     * @uses \Spryker\Glue\GlueApplication\GlueApplicationConfig::COLLECTION_IDENTIFIER_CURRENT_USER
     *
     * @var string
     */
    public const COLLECTION_IDENTIFIER_CURRENT_USER = 'mine';
}
