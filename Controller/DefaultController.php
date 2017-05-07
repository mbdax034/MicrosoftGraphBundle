<?php

namespace Mbdax\MicrosoftGraphBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Mbdax\MicrosoftGraphBundle\DependencyInjection\OAuth;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        $oauth= new Oauth();
        
        $oauth->getToken();
        
        die();

        // return $this->render('XipoteraBundle:calendar.html.twig');
        return $response;
    }
    
    
    public function redirectAction()
    {


        // return $this->render('XipoteraBundle:calendar.html.twig');
        return $this->render('MicrosoftGraphBundle:Default:index.html.twig');
    }

    /**
     * Link to this controller to start the "connect" process
     *
     * 
     */
    public function connectAction()
    {
        // will redirect to Office365!
        return $this->get('oauth2.registry')
            ->getClient('microsoft_graph') // key used in config.yml
            ->redirect();
    }

    /**
     * After going to Office365, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * 
     */
    public function connectCheckAction(Request $request)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient $client */
        
        // $client = $this->get('oauth2.registry')
        //     ->getClient('microsoft_graph');
        $client = $this->get('knpu.oauth2.client.microsoft_graph');
           
        dump($client->fetchUser());
        die();
        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
           // $user = $client->fetchUser();

            // do something with all this new power!
            //$user->getFirstName();
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());die;
        }
    }
}
