<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Auth;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Spryker\Client\Auth\AuthFactory getFactory()
 */
class AuthClient extends AbstractClient implements AuthClientInterface
{

    /**
     * @api
     *
     * @param string $rawToken
     *
     * @return string
     */
    public function generateToken($rawToken)
    {
        return $this->getTokenService()->generate($rawToken);
    }

    /**
     * @api
     *
     * @param string $rawToken
     * @param string $hash
     *
     * @return bool
     */
    public function checkToken($rawToken, $hash)
    {
        return $this->getTokenService()->check($rawToken, $hash);
    }

    /**
     * @return \Spryker\Client\Auth\Token\TokenService
     */
    private function getTokenService()
    {
        return $this->getFactory()->createTokenService();
    }

}
