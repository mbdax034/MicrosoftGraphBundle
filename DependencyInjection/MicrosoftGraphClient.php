<?php

/*
 * OAuth2 Client Bundle
 * Copyright (c) KnpUniversity <http://knpuniversity.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;

use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use MicrosoftGraphProvider;
use League\OAuth2\Client\Token\AccessToken;

class MicrosoftGraphClient extends OAuth2Client
{

    /** @var AbstractProvider */
    private $provider;

    /** @var RequestStack */
    private $requestStack;

    /** @var bool */
    private $isStateless = false;

    /**
     * OAuth2Client constructor.
     *
     * @param AbstractProvider $provider
     * @param RequestStack $requestStack
     */
    public function __construct(AbstractProvider $provider, RequestStack $requestStack)
    {
         parent::__construct( $provider,$requestStack);
        $this->provider = $provider;
        $this->requestStack = $requestStack;
    }

    /**
     * @param AccessToken $accessToken
     * @return MicrosoftGraphProvider
     */
    public function fetchUserFromToken(AccessToken $accessToken)
    {
          return $this->provider->getResourceOwner([],$accessToken);
    }

    /**
     * @return MicrosoftGraphProvider
     */
    public function fetchUser()
    {
        return parent::fetchUser();
    }
}