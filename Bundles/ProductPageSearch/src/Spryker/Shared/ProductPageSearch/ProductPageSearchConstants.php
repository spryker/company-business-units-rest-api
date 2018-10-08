<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\ProductPageSearch;

use Spryker\Shared\Search\SearchConstants;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
class ProductPageSearchConstants
{
    /**
     * Specification:
     * - Queue name as used for processing Product messages
     *
     * @api
     */
    public const PRODUCT_SYNC_SEARCH_QUEUE = 'sync.search.product';

    /**
     * Specification:
     * - Queue name as used for processing Product messages
     *
     * @api
     */
    public const PRODUCT_SYNC_SEARCH_ERROR_QUEUE = 'sync.search.product.error';

    /**
     * Specification:
     * - Resource name, this will use for key generating
     *
     * @api
     */
    public const PRODUCT_ABSTRACT_RESOURCE_NAME = 'product_abstract';

    /**
     * Specification:
     * - Resource name, will be used for key generating
     *
     * @api
     */
    public const PRODUCT_CONCRETE_RESOURCE_NAME = 'product_concrete';

    /**
     * @uses SearchConstants
     */
    public const FULL_TEXT_BOOSTED_BOOSTING_VALUE = SearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE;
}
