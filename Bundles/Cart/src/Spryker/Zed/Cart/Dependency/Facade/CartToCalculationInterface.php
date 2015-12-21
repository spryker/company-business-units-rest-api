<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Cart\Dependency\Facade;

use Spryker\Zed\Calculation\Business\Model\CalculableInterface;

interface CartToCalculationInterface
{

    /**
     * @param CalculableInterface $calculableContainer
     *
     * @return CalculableInterface
     */
    public function recalculate(CalculableInterface $calculableContainer);

}
