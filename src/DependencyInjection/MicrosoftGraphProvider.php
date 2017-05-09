<?php

/**
 * @author Abdellah Rabh
 * @email abderabh@mail.com
 * @create date 2017-05-09 10:59:45
 * @modify date 2017-05-09 10:59:45
 * @desc [description]
*/

namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphResourceOwner as User;



class MicrosoftGraphProvider extends GenericProvider{

    const AUTHORITY_URL='https://login.microsoftonline.com/common';
    const RESOURCE_ID='https://graph.microsoft.com';
    /**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';


    public function __construct(array $options = []){

        parent::__construct($options  );
        
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new User($response, self::ACCESS_TOKEN_RESOURCE_OWNER_ID);
    
    }
    
}