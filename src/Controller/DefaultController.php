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
            
            try{

               $client->getNewToken();

            }catch(\Exception $ex){
              // exeption if fault token parameter  or no refresh token
               $client->redirect();
            }

            $startTime = new DateTime("01-05-2017");
            $endTime = new DateTime("29-05-2017");
            $calendar= $this->get('microsoft_graph.calendar');
            $events = $calendar->getEvents($startTime,$endTime); 
            $event= $calendar->getEvent($events[0]->getId());
            dump($events);
            dump($event);

        
            
            $newEvent= new Model\Event();
     
            
              
            $start= $calendar->getDateTimeTimeZone(new \DateTime('Now next minute'));
            $end= $calendar->getDateTimeTimeZone(new \DateTime('Now next hour'));
            dump($start);
            dump($end);

            $newEvent->setSubject('Controller Test Token');
            $newEvent->setStart($start);
            $newEvent->setEnd( $end);

           
            

            $event= $calendar->addEvent( $newEvent);

            dump($event);
            // Update an event 
           
            $updateEvent= new Model\Event();
            $updateEvent->setId($event->getId());
            $updateEvent->setSubject('Controller Test Token updated');

            $event= $calendar->updateEvent( $updateEvent);
           dump($event);
            $response= $calendar->deleteEvent( $updateEvent->getID());
           dump($response->getStatus()==204?"Event deleted":$response);

            $session->set('microsoft_graph_expires',time()-51);
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
