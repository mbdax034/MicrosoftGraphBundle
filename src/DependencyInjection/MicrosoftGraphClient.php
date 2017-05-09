<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@mail.com
 * @create date 2017-05-09 10:50:16
 * @modify date 2017-05-09 10:50:16
 * @desc [description]
*/



namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;


use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphProvider;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use \Exception;

class MicrosoftGraphClient 
{
    /**
     * 
     */
    const OAUTH2_SESSION_STATE_KEY = 'microsoft_graph_client_state';
    /**
     * 
     */
    const AUTHORITY_URL='https://login.microsoftonline.com/common';
    /**
     * 
     */
    const RESOURCE_ID='https://graph.microsoft.com';
    /** @var AbstractProvider */
    private $provider;
    /** @var RequestStack */
    private $requestStack;
    /** @var bool */
    private $isStateless = false;

    private $config;
    /**
     * OAuth2Client constructor.
     *
     * @param AbstractProvider $provider
     * @param RequestStack $requestStack
     */
    public function __construct( RequestStack $requestStack,Container $container)
    {
        $this->requestStack = $requestStack;
        $this->config = $container->getParameter('microsoft_graph');

        $options=[
            'clientId'=> $this->config['client_id'],
            'clientSecret'=> $this->config['client_secret'],
            'redirectUri'=> "http://localhost:8000".$container->get('router')->generate($this->config['redirect_uri']),
            'urlResourceOwnerDetails'=>self::RESOURCE_ID."/v1.0/me",
            "urlAccessToken"=>self::AUTHORITY_URL.'/oauth2/v2.0/token',
            "urlAuthorize"=>self::AUTHORITY_URL.'/oauth2/v2.0/authorize',
            
        ];

      
        $this->isStateless=$this->config['stateless'];
   
        
        $this->provider = new MicrosoftGraphProvider($options);

    }
    /**
     * Call this to avoid using and checking "state".
     */
    public function setAsStateless()
    {
        $this->isStateless = true;
        return $this;
    }
    /**
     * Creates a RedirectResponse that will send the user to the
     * OAuth2 server (e.g. send them to Facebook).
     *
     * @param array $scopes  The scopes you want (leave empty to use default)
     * @param array $options Extra options to pass to the "Provider" class
     * @return RedirectResponse
     */
    public function redirect()
    {
        $options=[];
        $scopes= $this->config["scopes"];
        if (!empty($scopes)) {
            $options['scope'] = implode(" ",$scopes);
        }
        $url = $this->provider->getAuthorizationUrl($options);
        // set the state (unless we're stateless)
        if (!$this->isStateless) {
            die();
            $this->getSession()->set(
                self::OAUTH2_SESSION_STATE_KEY,
                $this->provider->getState()
            );
        }
        return new RedirectResponse($url);
    }
    /**
     * Call this after the user is redirected back to get the access token.
     *
     * @return \League\OAuth2\Client\Token\AccessToken
     *
     * @throws Exception if invalid state
     * @throws Exception If token cannot be fetched
     */
    public function getAccessToken()
    {
        if (!$this->isStateless) {
            $expectedState = $this->getSession()->get(self::OAUTH2_SESSION_STATE_KEY);
            $actualState = $this->getCurrentRequest()->query->get('state');
            if (!$actualState || ($actualState !== $expectedState)) {
                throw new Exception('Invalid state');
            }
        }
        $code = $this->getCurrentRequest()->get('code');
        if (!$code) {
            throw new Exception('No "code" parameter was found (usually this is a query parameter)!');
        }
        
        return $this->provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);
    }
    /**
     * Returns the "User" information (called a resource owner).
     *
     * @param AccessToken $accessToken
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    public function fetchUserFromToken(AccessToken $accessToken)
    {
        
        return $this->provider->getResourceOwner($accessToken);
    }
    /**
     * Shortcut to fetch the access token and user all at once.
     *
     * Only use this if you don't need the access token, but only
     * need the user.
     *
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    public function fetchUser()
    {
        $token = $this->getAccessToken();
     
        
        return $this->fetchUserFromToken($token);
    }
    /**
     * Returns the underlying OAuth2 provider.
     *
     * @return AbstractProvider
     */
    public function getOAuth2Provider()
    {
        return $this->provider;
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    private function getCurrentRequest()
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            throw new \Exception('There is no "current request", and it is needed to perform this action');
        }
        return $request;
    }
    /**
     * @return null|\Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    private function getSession()
    {
        $session = $this->getCurrentRequest()->getSession();
        if (!$session) {
            throw new \Exception('In order to use "state", you must have a session. Set the OAuth2Client to stateless to avoid state');
        }
        return $session;
    }

}