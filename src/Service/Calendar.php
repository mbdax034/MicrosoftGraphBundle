<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-10 09:40:15
 * @modify date 2017-05-10 09:40:15
 * @desc [description]
*/


namespace Mbdax\MicrosoftGraphBundle\Service;

use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphRequest;
use Microsoft\Graph\Model;
use DateTime;

class Calendar{

        /**
         * Request prepared with Prefered time_zone
         *
         * @var MicrosoftGraphRequest
         */
        private $request;

        public function __construct(MicrosoftGraphRequest $request){
            $this->request = $request;
        } 




        // Get an Event
        public function getEvent($idEvent){
            if($idEvent==NULL)
                throw new Exception("Your idEvent is null");

            return $this->request
                            ->createRequest('GET','/me/events/'.$idEvent,true)
                            ->execute();
        }
        
        // Create an event

        public function addEvent($data){
            if($data==NULL)
                throw new Exception("Your idEvent is null");

            return $this->request
                            ->createRequest('POST','/me/events',true)
                            ->attachBody($data)
                            ->execute();
        }

        // Update an event

        // Delete an event

        // Accept an event

        // Get list of events

        /**
         * Format 
         * @param DateTime $date
         * @return string 
         */
        public function formatDate(DateTime $date){
            return  $date->format('Y-m-d H:i:s');

        }

        public function getEvents(DateTime $start,DateTime $end){

            $start->setTime(0, 0, 0);
            $end->modify('+1 day');

            $startTime = $this->formatDate($start);
            $endTime = $this->formatDate($end);

            $route= "/me/calendarView?startDateTime=$startTime&endDateTime=$endTime";

            // dump($startTime);
            // dump($endTime);
            // dump($route);
           
            

          $events=  $this->request->createCollectionRequest("GET", $route,true )
                ->setReturnType(Model\Event::class)
                ->execute();
            
            return $events;
        }

        // Decline 

        // List attachement


        //Add attachement

        


}

