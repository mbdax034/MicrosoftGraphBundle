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

class SessionStorage  implements TokenStorageInterface{

 
    private $session;

    public function __construct(Session $session){
        $this->session= $session;

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
            
            return new AccessToken($options);
    }
}
