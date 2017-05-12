<?php

namespace Mbdax\MicrosoftGraphBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }

    public function redirect(){
        $client= $this->get('microsoft_graph.client');
        $client->redirect();
    }

    public function getToken(){
        $client= $this->get('microsoft_graph.client');
        $client->getNewToken();
    }

    public function calendarTest(){
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
            
        
            
            $newEvent= new Model\Event();
     
            
              
            $start= $calendar->getDateTimeTimeZone(new \DateTime('Now next minute'));
            $end= $calendar->getDateTimeTimeZone(new \DateTime('Now next hour'));
           

            $newEvent->setSubject('Controller Test Token');
            $newEvent->setStart($start);
            $newEvent->setEnd( $end);

           
            

            $event= $calendar->addEvent( $newEvent);

           
            $updateEvent= new Model\Event();
            $updateEvent->setId($event->getId());
            $updateEvent->setSubject('Controller Test Token updated');

            $event= $calendar->updateEvent( $updateEvent);
          
            $response= $calendar->deleteEvent( $updateEvent->getID());
           dump($response->getStatus()==204?"Event deleted":$response);

            $session->set('microsoft_graph_expires',time()-51);
            

    }
}
