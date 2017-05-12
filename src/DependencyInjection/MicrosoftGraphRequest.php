<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-10 09:44:28
 * @modify date 2017-05-10 09:44:28
 * @desc [description]
*/




namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;

use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphClient;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class MicrosoftGraphRequest{
        /**
         * Undocumented variable
         *
         * @var MicrosoftGraphClient
         */
        private $client;
        private $graph;
        private $request;

        public function __construct(MicrosoftGraphClient $client){
            $this->client = $client;
            $this->graph= new Graph();

            
        }
        
        public function setVersion($version=""){
            if(in_array($version,['v1.0','beta'])){
                $this->graph->setApiVersion($version);
            }else{
                $version= $this->client->getConfig()['version'];
                if(in_array($version,['v1.0','beta']))
                    $this->graph->setApiVersion();
            }
        }
        public function getToken(){
            return $this->client->getNewToken()->getToken();
        }

        public function setTokenGraph(){
             $this->graph->setAccessToken($this->getToken());
        }

        public function getConfig($key){
            return $this->client->getConfig()[$key];
        }

        public function getPreferTimeZone(){
                $prefer= 'outlook.timezone="'.$this->getConfig('prefer_time_zone').'"';

               
                return $prefer;
        }

        
        public function createRequest($requestType, $endpoint,$preferedTimeZone=False){
            
            $this->setTokenGraph();

            $request= $this->graph->createRequest($requestType, $endpoint);
            
            if($preferedTimeZone){
                $request->addHeaders(["Prefer"=>$this->getPreferTimeZone()]);
            }
            return $request;
        }


        public function createCollectionRequest($requestType, $endpoint,$preferedTimeZone=False){

            $this->setTokenGraph();

            $createCollectionRequest= $this->graph->createCollectionRequest($requestType, $endpoint);
            
           
            if($preferedTimeZone)
                $createCollectionRequest->addHeaders(["Prefer"=>$this->getPreferTimeZone()]);

            return $createCollectionRequest;
        }


        /**
         * Format 
         * @param DateTime $date
         * @return string 
         */
        public function getDateMicrosoftFormat(\DateTime $date){
            return  $date->format('Y-m-d\TH:i:s');

        }

        /**
         *  Create a DateTimeTimeZone for Windows
         * With prefer time zone 
         * @param DateTime $date
         * @return Model\DateTimeTimeZone
         */
        public function getDateTimeTimeZone(\DateTime $date){
            $dateTime= $this->getDateMicrosoftFormat($date);
            $timezone= $this->getConfig('prefer_time_zone');

            return  new Model\DateTimeTimeZone(['dateTime'=>$dateTime,'timezone'=>$timezone]);
            
        }
}