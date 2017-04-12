<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Sales\Presentation;

use SprykerTest\Zed\Sales\PresentationTester;
use SprykerTest\Zed\Sales\Presentation\PageObject\SalesDetailPage;
use SprykerTest\Zed\Sales\Presentation\PageObject\SalesListPage;

/**
 * Auto-generated group annotations
 * @group Sales
 * @group ZedPresentation
 * @group SalesDetailCest
 * Add your own group annotations below this line
 */
class SalesDetailCest
{

    /**
     * @param \SprykerTest\Zed\Sales\PresentationTester $i
     * @param \SprykerTest\Zed\Sales\Presentation\PageObject\SalesListPage $salesListPage
     *
     * @return void
     */
    public function testThatOrderDetailPageIsVisibleWhenOrderExists(PresentationTester $i, SalesListPage $salesListPage)
    {
        $i->createOrderWithOneItem();

        $idSalesOrder = $salesListPage->grabLatestOrderId();

        $i->amOnPage(SalesDetailPage::getOrderDetailsPageUrl($idSalesOrder));

        $i->waitForElement('#items', 3);
        $i->seeElement(['xpath' => SalesDetailPage::getSalesOrderItemRowSelector(1)]);
    }

}
