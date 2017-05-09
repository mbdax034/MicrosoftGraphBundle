<?php

namespace Mbdax\MicrosoftGraphBundle\Entity;

use League\OAuth2\Client\Token\AccessToken;

/**
 * Base token interface for any OAuth version.
 */
interface MicrosoftGraphTokenInterface {

        /**
         * Undocumented function
         *
         * @param AccessToken $accessToken
         * @return void
         */
        public function setMicrosoftGraphToken(AccessToken $accessToken);
        /**
         * Undocumented function
         *
         * @return AccessToken $accessToken
         */
        public function getMicrosoftGraphToken();
   
}