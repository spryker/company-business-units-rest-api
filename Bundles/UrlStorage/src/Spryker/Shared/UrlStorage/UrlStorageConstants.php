<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\UrlStorage;

class UrlStorageConstants
{
    /**
     * Specification:
     * - Queue name as used for processing url messages
     *
     * @api
     */
    const URL_SYNC_STORAGE_QUEUE = 'sync.storage.url';

    /**
     * Specification:
     * - Queue name as used for processing URL messages
     *
     * @api
     */
    const URL_SYNC_STORAGE_ERROR_QUEUE = 'sync.storage.url.error';

    /**
     * Specification:
     * - Resource name, this will use for key generating
     *
     * @api
     */
    const URL_RESOURCE_NAME = 'url';

    /**
     * Specification:
     * - Resource name, this will use for key generating
     *
     * @api
     */
    const REDIRECT_RESOURCE_NAME = 'redirect';
}