<?php

namespace Mbdax\MicrosoftGraphBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Mbdax\MicrosoftGraphBundle\DependencyInjection\OAuth;

class DefaultController extends Controller
{
     /**
     * @Route("/graph", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        
        

        return $this->render('MicrosoftGraphBundle:Default:index.html.twig');
       
        return $response;
    }
    
   

    /**
     * @Route("/graph/login", name="graph_login")
     */
    public function connectAction()
    {
        // will redirect to Office365!
        return $this->get('microsoft_graph.client')->setAsStateless()
            ->redirect();
    }

    /**
     * After going to Office365, you're redirected back here
     * because this is the "graph_check" you configured
     * in config.yml
     *@Route("/graph/check", name="graph_check")
     * 
     */
    public function connectCheckAction(Request $request)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
        $client=$this->get('microsoft_graph.client');
            
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
