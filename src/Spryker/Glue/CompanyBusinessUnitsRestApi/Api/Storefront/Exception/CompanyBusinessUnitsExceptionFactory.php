<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Api\Storefront\Exception;

use Spryker\ApiPlatform\Exception\GlueApiException;
use Spryker\Glue\CompanyBusinessUnitsRestApi\CompanyBusinessUnitsRestApiConfig;
use Symfony\Component\HttpFoundation\Response;

class CompanyBusinessUnitsExceptionFactory
{
    /**
     * BC: legacy `GET /company-business-units` (no id) returned a 501 error envelope without a
     * Spryker `code` field at all. We pass an empty string to {@see GlueApiException}
     * so the emitted error envelope matches the legacy contract (no `code` key value).
     */
    protected const string RESPONSE_CODE_RESOURCE_NOT_IMPLEMENTED = '';

    public function createCompanyBusinessUnitNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            CompanyBusinessUnitsRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_NOT_FOUND,
            CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_COMPANY_BUSINESS_UNIT_NOT_FOUND,
        );
    }

    public function createCompanyUserNotSelectedException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_FORBIDDEN,
            CompanyBusinessUnitsRestApiConfig::RESPONSE_CODE_COMPANY_USER_NOT_SELECTED,
            CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_COMPANY_USER_NOT_SELECTED,
        );
    }

    public function createResourceNotImplementedException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_IMPLEMENTED,
            static::RESPONSE_CODE_RESOURCE_NOT_IMPLEMENTED,
            CompanyBusinessUnitsRestApiConfig::RESPONSE_DETAIL_RESOURCE_NOT_IMPLEMENTED,
        );
    }
}
