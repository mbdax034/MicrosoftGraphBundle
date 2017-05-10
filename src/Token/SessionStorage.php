<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@mail.com
 * @create date 2017-05-09 11:03:19
 * @modify date 2017-05-09 11:03:19
 * @desc [description]
*/


namespace Mbdax\MicrosoftGraphBundle\Token;

use League\OAuth2\Client\Token\AccessToken;
use Mbdax\MicrosoftGraphBundle\Token\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use InvalidArgumentException;
use Mbdax\MicrosoftGraphBundle\Exception\RedirectException;

class SessionStorage  implements TokenStorageInterface{

 
    private $session;
    private $container;

    public function __construct(Session $session, Container $container){
        $this->session= $session;
        $this->container= $container;
    }


    public function setToken(AccessToken $token){

        // store an attribute for reuse during a later user request
            $this->session->set('microsoft_graph_accesstoken', $token->getToken());
            $this->session->set('microsoft_graph_refreshtoken', $token->getRefreshToken());
            $this->session->set('microsoft_graph_expires',$token->getExpires() );
            $this->session->set('microsoft_graph_resourceOwnerId',$token->getResourceOwnerId() );
            
    }

    public function getToken(){

            $options['access_token']=$this->session->get('microsoft_graph_accesstoken');
            $options['refresh_token']=$this->session->get('microsoft_graph_refreshtoken');
            $options['expires']=$this->session->get('microsoft_graph_expires');
            $options['resource_owner_id']=$this->session->get('microsoft_graph_resourceOwnerId' );
       
            
            
            $token= new AccessToken($options);
            return $token;
            
    }
}
