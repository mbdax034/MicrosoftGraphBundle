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
            // get graph token storage
            
            $client= $this->get('microsoft_graph.client');
            $session= $this->get('session');
            
            dump($client->getNewToken());

            $startTime = new DateTime("01-05-2017");
            $endTime = new DateTime("29-05-2017");
            $calendar= $this->get('microsoft_graph.calendar');
            $events = $calendar->getEvents($startTime,$endTime); 
            $event= $calendar->getEvent($events[0]->getId());
            dump($events);
            dump($event);

            $session->set('microsoft_graph_expires',null);
            die();

        return $this->render('MicrosoftGraphBundle:Default:index.html.twig');
       
        return $response;
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
            
            //$user= $client->fetchUser();
            $token=$client->getAccessToken();

             $tokenStorage =$this->get("microsoft_graph.session_storage");

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
