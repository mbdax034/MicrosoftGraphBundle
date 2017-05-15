<?php
/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-15 03:00:08
 * @modify date 2017-05-15 03:00:08
 * @desc [description]
*/




namespace Mbdax\MicrosoftGraphBundle\Service;

use Mbdax\MicrosoftGraphBundle\DependencyInjection\MicrosoftGraphRequest;
use Microsoft\Graph\Model;
use DateTime;

class Drive{

        /**
         *
         * @var MicrosoftGraphRequest
         */
        private $request;

        public function __construct(MicrosoftGraphRequest $request){
            $this->request = $request;
        }




        function getMeDrive(){


        }

        public function getChildrenForDrive($drive){
            $route= '/drives/'.$drive.'/root/children';

           
            //$this->request->setVersion('beta');
            $items=  $this->request->createCollectionRequest("GET", $route,true )
                    ->setReturnType(Model\DriveItem::class)
                    ->execute();
            
            return $items;

        }

        function getChildrenForDriveItem($drive,$item){

            $route= '/drives/'.$drive.'/items/'.$item.'/children';

           
            $this->request->setVersion('beta');
          $items=  $this->request->createCollectionRequest("GET", $route,true )
                ->setReturnType(Model\DriveItem::class)
                ->execute();
            
            return $items;
        }
        

}
