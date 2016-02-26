<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Collector\Business;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Messenger\Business\Model\MessengerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\Collector\Business\CollectorBusinessFactory getFactory()
 */
class CollectorFacade extends AbstractFacade implements CollectorFacadeInterface
{

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param \Symfony\Component\Console\Output\OutputInterface|null $output
     *
     * @return \Spryker\Zed\Collector\Business\Model\BatchResultInterface[]
     */
    public function exportKeyValueForLocale(LocaleTransfer $locale, OutputInterface $output = null)
    {
        $exporter = $this->getFactory()->createYvesKeyValueExporter();

        return $exporter->exportForLocale($locale, $output);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Spryker\Zed\Collector\Business\Model\BatchResult[]
     */
    public function exportSearchForLocale(LocaleTransfer $locale)
    {
        $exporter = $this->getFactory()->createYvesSearchExporter();

        return $exporter->exportForLocale($locale);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Spryker\Zed\Collector\Business\Model\BatchResult[]
     */
    public function updateSearchForLocale(LocaleTransfer $locale)
    {
        $exporter = $this->getFactory()->createYvesSearchUpdateExporter();

        return $exporter->exportForLocale($locale);
    }

    /**
     * @api
     *
     * @param \Spryker\Zed\Messenger\Business\Model\MessengerInterface $messenger
     *
     * @return void
     */
    public function install(MessengerInterface $messenger)
    {
        $this->getFactory()->createInstaller($messenger)->install();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSearchIndexName()
    {
        return $this->getFactory()->getConfig()->getSearchIndexName();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSearchDocumentType()
    {
        return $this->getFactory()->getConfig()->getSearchDocumentType();
    }

    /**
     * @api
     *
     * @param array $keys
     *
     * @return bool
     */
    public function deleteSearchTimestamps(array $keys = [])
    {
        return $this->getFactory()->createSearchMarker()->deleteTimestamps($keys);
    }

    /**
     * @api
     *
     * @param array $keys
     *
     * @return bool
     */
    public function deleteStorageTimestamps(array $keys = [])
    {
        return $this->getFactory()->createKeyValueMarker()->deleteTimestamps($keys);
    }

}
