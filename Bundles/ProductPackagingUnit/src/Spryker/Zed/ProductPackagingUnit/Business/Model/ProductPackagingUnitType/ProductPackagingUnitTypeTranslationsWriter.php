<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnit\Business\Model\ProductPackagingUnitType;

use Generated\Shared\Transfer\ProductPackagingUnitTypeTransfer;
use Generated\Shared\Transfer\TranslationTransfer;
use Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToGlossaryInterface;
use Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToLocaleInterface;

class ProductPackagingUnitTypeTranslationsWriter implements ProductPackagingUnitTypeTranslationsWriterInterface
{
    /**
     * @var \Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var \Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToGlossaryInterface
     */
    protected $glossaryFacade;

    /**
     * @param \Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToLocaleInterface $localeFacade
     * @param \Spryker\Zed\ProductPackagingUnit\Dependency\Facade\ProductPackagingUnitToGlossaryInterface $glossaryFacade
     */
    public function __construct(
        ProductPackagingUnitToLocaleInterface $localeFacade,
        ProductPackagingUnitToGlossaryInterface $glossaryFacade
    ) {
        $this->localeFacade = $localeFacade;
        $this->glossaryFacade = $glossaryFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPackagingUnitTypeTransfer $productPackagingUnitTypeTransfer
     *
     * @return void
     */
    public function saveTranslations(ProductPackagingUnitTypeTransfer $productPackagingUnitTypeTransfer): void
    {
        if (!$productPackagingUnitTypeTransfer->getName()) {
            return;
        }

        foreach ($productPackagingUnitTypeTransfer->getNameTranslations() as $productPackagingUnitTypeNameTranslationTransfer) {
            $value = $productPackagingUnitTypeNameTranslationTransfer->getTranslation();
            $key = $productPackagingUnitTypeTransfer->getName();

            if (!$value) {
                $value = $key;
            }

            $this->saveTranslation($key, $value, $productPackagingUnitTypeNameTranslationTransfer->getLocaleCode());
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPackagingUnitTypeTransfer $productPackagingUnitTypeTransfer
     *
     * @return bool
     */
    public function deleteTranslations(ProductPackagingUnitTypeTransfer $productPackagingUnitTypeTransfer): bool
    {
        $translationKey = $productPackagingUnitTypeTransfer->getName();

        return $this->glossaryFacade->deleteKey($translationKey);
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $localeCode
     *
     * @return \Generated\Shared\Transfer\TranslationTransfer
     */
    protected function saveTranslation($key, $value, $localeCode): TranslationTransfer
    {
        if (!$this->glossaryFacade->hasKey($key)) {
            $this->glossaryFacade->createKey($key);
        }

        $localeTransfer = $this->localeFacade->getLocaleByCode($localeCode);

        return $this->glossaryFacade->saveAndTouchTranslation($key, $value, $localeTransfer);
    }
}
