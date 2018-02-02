<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Model;

use Generated\Shared\Transfer\SpyDatasetColEntityTransfer;

interface DatasetColSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyDatasetColEntityTransfer $datasetColEntityTransfer
     *
     * @return \Orm\Zed\Dataset\Persistence\SpyDataset
     */
    public function getOrCreate(SpyDatasetColEntityTransfer $datasetColEntityTransfer);
}
