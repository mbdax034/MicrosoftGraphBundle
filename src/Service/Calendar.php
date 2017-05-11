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
        
        /**
         *  Create a DateTimeTimeZone for Windows
         * With prefer time zone 
         * @param DateTime $date
         * @return Model\DateTimeTimeZone
         */
        public function getDateTimeTimeZone(DateTime $date){
            return  $this->request->getDateTimeTimeZone($date);
        }

        
        /**
         * Create an event
         * Undocumented function
         *
         * @param Model\Event $event
         * @return void
         */
        public function addEvent(Model\Event $event){
            if($event==NULL)
                throw new Exception("Your event is null");
            
           
            return $this->request
                            ->createRequest('POST','/me/events',true)
                            ->attachBody($event->jsonSerialize())
                            ->setReturnType(Model\Event::class)
                            ->execute();
        }

        /**
         * Update an event
         * Undocumented function
         *
         * @param Model\Event $event
         * @return void
         */
        public function updateEvent(Model\Event $event){
            if($event==NULL)
                throw new Exception("Your event is null");
            
           
            return $this->request
                            ->createRequest('PATCH','/me/events/'.$event->getId(),true)
                            ->attachBody($event->jsonSerialize())
                            ->setReturnType(Model\Event::class)
                            ->execute();
        }
        
        
        /**
         * Delete an event
         * Undocumented function
         *
         * @param Model\Event $event
         * @return void
         */
        public function deleteEvent($id){
            if($id==NULL)
                throw new Exception(" id is null");
            
           
            return $this->request
                            ->createRequest('DELETE','/me/events/'.$id,true)
                            ->execute();
        }

        // Accept an event

        // Get list of events

        /**
         * Format 
         * @param DateTime $date
         * @return string 
         */
        public function formatDate(DateTime $date){           
            return   $this->request->getDateMicrosoftFormat($date);

        }

        public function getEvents(DateTime $start,DateTime $end){

            $start->setTime(0, 0, 0);
            $end->modify('+1 day');
            $startTime = $this->formatDate($start);
            $endTime = $this->formatDate($end);
            $route= "/me/calendarView?startDateTime=$startTime&endDateTime=$endTime";
          $events=  $this->request->createCollectionRequest("GET", $route,true )
                ->setReturnType(Model\Event::class)
                ->execute();
            
            return $events;
        }

        // Decline 

        // List attachement


        //Add attachement

        


}

