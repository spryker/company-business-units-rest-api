<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Shared\Money\Formatter\IntlMoneyFormatter;

use Generated\Shared\Transfer\MoneyTransfer;
use Money\Currency;
use Money\Money;
use Spryker\Shared\Money\Converter\TransferToMoneyConverterInterface;

/**
 * @group Unit
 * @group Spryker
 * @group Shared
 * @group Money
 * @group Formatter
 */
abstract class AbstractIntlMoneyFormatterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Shared\Money\Converter\TransferToMoneyConverterInterface
     */
    protected function getTransferToMoneyConverterMock()
    {
        $transferToMoneyConverterMock = $this->getMockBuilder(TransferToMoneyConverterInterface::class)->getMock();
        $transferToMoneyConverterMock->method('convert')->willReturnCallback([$this, 'convert']);

        return $transferToMoneyConverterMock;
    }

    /**
     * @param \Generated\Shared\Transfer\MoneyTransfer $moneyTransfer
     *
     * @return \Money\Money
     */
    public function convert(MoneyTransfer $moneyTransfer)
    {
        $money = new Money($moneyTransfer->getAmount(), new Currency($moneyTransfer->getCurrency()));

        return $money;
    }

}
