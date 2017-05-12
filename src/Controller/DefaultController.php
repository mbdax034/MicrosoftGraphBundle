<?php

namespace Mbdax\MicrosoftGraphBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use \DateTime;

class DefaultController extends Controller
{
     
    public function indexAction(Request $request)
    {
           
        return $this->render('MicrosoftGraphBundle:Default:index.html.twig');
       

    }
    
   

    
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
     * 
     */
    public function connectCheckAction(Request $request)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
        
     
        try {
            // the exact class depends on which provider you're using

            /** @var Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphClient */
            $client=$this->get('microsoft_graph.client');
            /**
             * @var \Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphResourceOwner
             */
            
            
            $token=$client->getAccessToken();

             $storage_manager= $this->getParameter("microsoft_graph")["storage_manager"];
             $tokenStorage =$this->get($storage_manager);

             $tokenStorage->setToken($token);

             $homePage= $this->getParameter("microsoft_graph")["home_page"];
             return new RedirectResponse( $this->generateUrl($homePage));
             
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());die;
        }
    }
}
