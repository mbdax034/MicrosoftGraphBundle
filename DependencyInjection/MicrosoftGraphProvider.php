<?php

namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;
use \League\OAuth2\Client\Provider\GenericProvider;
use \League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use MicrosoftGraphResourceOwner as User;


class MicrosoftGraphProvider extends AbstractProvider{

    const AUTHORITY_URL='https://login.microsoftonline.com/common';
    const RESOURCE_ID='https://graph.microsoft.com';
    /**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = "id_token";



 public function getBaseAuthorizationUrl(){
      return self::AUTHORITY_URL.'/oauth2/v2.0/authorize';
 }
 public function getBaseAccessTokenUrl(array $params){
      return self::AUTHORITY_URL.'/oauth2/v2.0/token';
 }
 public function getResourceOwnerDetailsUrl(AccessToken $token){
    return self::RESOURCE_ID.'/v1.0/me/';
 }
 public function getDefaultScopes(){
     
     return implode(" ",["openid", 
         "offline_access",
         "https://outlook.office.com/calendars.readwrite",
         "https://outlook.office.com/mail.readwrite",
         "https://outlook.office.com/profile"
     ]);
 }
 public function checkResponse(ResponseInterface $response, $data){
     
   
    if (isset($data['error'])==TRUE) {
           
            $code  = 0;
            $error = $data['error'];
            
            if (is_array($error)) {
                $code  = $error['code'];
                $error = $error['message'];
            }
            
            throw new IdentityProviderException($error, $code, $data);
        }

    return true;
      
 }

 /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return MicrosoftGraphResourceOwner
     */
 public function createResourceOwner(array $response, AccessToken $token){

       
        $user = new User($response,$token);

        dump($user);
        //$imageUrl = $this->getUserImageUrl($response, $token);
        return $user;//$user->setImageurl($imageUrl);
 }


 /**
     * Get user image from provider
     *
     * @param  array        $response
     * @param  AccessToken  $token
     *
     * @return array
     */
    protected function getUserImage(array $response, AccessToken $token)
    {
        $url = 'https://apis.live.net/v5.0/'.$response['id'].'/picture';
        $request = $this->getAuthenticatedRequest('get', $url, $token);
        $response = $this->getResponse($request);
        return json_decode((string) $response->getBody(), true);
    }


     /**
     * Get user image url from provider, if available
     *
     * @param  array        $response
     * @param  AccessToken  $token
     *
     * @return string
     */
    protected function getUserImageUrl(array $response, AccessToken $token)
    {
        $image = $this->getUserImage($response, $token);
        if (isset($image['url'])) {
            return $image['url'];
        }
        return null;
    }

    
}