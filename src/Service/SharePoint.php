<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-12 11:41:05
 * @modify date 2017-05-12 11:41:05
 * @desc [description]
*/



namespace Mbdax\MicrosoftGraphBundle\Service;

use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphRequest;
use Microsoft\Graph\Model;
use DateTime;

class SharePoint{

        /**
         * Request prepared with Prefered time_zone
         *
         * @var MicrosoftGraphRequest
         */
        private $request;

        public function __construct(MicrosoftGraphRequest $request){
            $this->request = $request;
        } 


        

        /***********************************************************
         *                          SITES
         * *********************************************************/
        
        /**
         * Undocumented function
         *
         * @return void
         */
        public function getRoot(){
            return $this->request
                            ->createRequest('GET','/sites/root')
                            ->setReturnType(Model\Root::class)
                            ->execute();
        }


        /**
         * Undocumented function
         *
         * @param int $id
         * @return void
         */
        public function getSite($id){
            if($id==NULL)
                throw new Exception("Your id is null");

            return $this->request
                            ->createRequest('GET','/sites/'.$id)
                            ->setReturnType(Model\DriveItem::class)
                            ->execute();
                            
        }

        /**
         * Not implemented by Microsoft
         * @deprecated v0.1.0
         * @param int $id
         * @return void
         */
        public function getListsOfSite($id){
            
            $route= '/sites/'.$id.'/lists';
            $this->request->setVersion('beta');
            $lists=  $this->request->createCollectionRequest("GET", $route,true )
                ->setReturnType(Model\DriveItem::class)
                ->execute();
                
            return $lists;
        }
        
        /**
         * Undocumented function
         *
         * @param int $id
         * @return void
         */
        public function getSubsitesOfSite($id){
            
            $route= '/sites/'.$id.'/sites';
            $this->request->setVersion('beta');
            $subsites=  $this->request->createCollectionRequest("GET", $route,true )
                //->setReturnType(Model\DriveItem::class)
                ->execute();
                
            return $subsites;
        }



        /***********************************************************
         *                          LISTES 
         * *********************************************************/

         /**
          * Undocumented function
          *
          * @param int $siteId
          * @param int $listId
          * @return void
          */
        public function getMetaDataOfList($siteId,$listId){

           
            $route= '/sites/'.$siteId.'/lists/'.$listId;

           
            $this->request->setVersion('beta');
          $meta=  $this->request->createRequest("GET", $route,true )  
                ->execute();
            
            return $meta;
        }
        
        /**
         * Undocumented function
         *
         * @param int $siteId
         * @param int $listId
         * @param array $params
         * @return void
         */
        public function getItemsOfList($siteId,$listId,$params=[]){

           
            $route= '/sites/'.$siteId.'/lists/'.$listId.'/itemes';

           
            $this->request->setVersion('beta');
          $items=  $this->request->createCollectionRequest("GET", $route,true )
                ->setReturnType(Model\DriveItem::class)
                ->execute();
            
            return $items;
        }

        /**
         * Undocumented function
         *
         * @param int $siteId
         * @param int $listId
         * @param array $params
         * @return void
         */
        public function newList($siteId,$listId,$params=[]){

           
            $route= '/sites/'.$siteId.'/lists/'.$listId.'/itemes';

           
            $this->request->setVersion('beta');
          $events=  $this->request->createCollectionRequest("POST", $route,true )
                ->setReturnType(Model\DriveItem::class)
                ->execute();
            
            return $events;
        }


}