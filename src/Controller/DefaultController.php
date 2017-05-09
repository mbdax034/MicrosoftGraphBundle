<?php

namespace Mbdax\MicrosoftGraphBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use \DateTime;
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
        
     
        try {
            // the exact class depends on which provider you're using

            /** @var Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphClient */
            $client=$this->get('microsoft_graph.client');
            /**
             * @var \Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphResourceOwner
             */
            
            //$user= $client->fetchUser();
            $token=$client->getAccessToken();

            $session = $request->getSession();

            // store an attribute for reuse during a later user request
            $session->set('microsoft_graph_accesstoken', 'bar');
            $session->set('microsoft_graph_refreshtoken', 'bar');
            $session->set('microsoft_graph_', 'bar');
            
            $graph = new Graph();
            $graph->setAccessToken($token->getToken());

            $startTime = new DateTime('today midnight');
            $startTime = $startTime->format('Y-m-d H:i:s');
            $endTime = new DateTime('tomorrow midnight');
            $endTime = $endTime->format('Y-m-d H:i:s');

            $events = $graph->createRequest("GET", "/me/calendarView?startDateTime=$startTime&endDateTime=$endTime")
                               ->setReturnType(Model\Event::class)
                               ->execute();

            dump($events[0]->jsonSerialize());
            die();
            // do something with all this new power!
            return new JsonResponse(["me"=>$user->getDisplayName()]);
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());die;
        }
    }
}
