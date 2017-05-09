<?php



namespace Mbdax\MicrosoftGraphBundle\Token;

use League\OAuth2\Client\Token\AccessToken;

interface  TokenStorageInterface
{
    

    public function getToken();
    public function setToken(AccessToken $token);
    
}
