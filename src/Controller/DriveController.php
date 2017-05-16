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

class DriveController extends Controller
{
     
    public function indexAction(Request $request)
    {

        return $this->render('MicrosoftGraphBundle:Default:drive.html.twig');
    }
    
   
   public function dataAction(Request $request){



        try{
                $client= $this->get('microsoft_graph.client');
                $client->getNewToken();
        }catch(\Exception $ex){
               $client->redirect();
        }

                $sharepoint= $this->get('microsoft_graph.sharepoint');
                $cal= $this->get('microsoft_graph.calendar');
                $drive_service= $this->get('microsoft_graph.drive');
        try{

               
                // get Root
                $root= $sharepoint->getRoot();


                //dump("Root drive");
                 $drive=$sharepoint->getRootDrive();
                
                $id= $request->get('id');
                
                $itemChildren=[];
                if($id){
                    $itemChildren= $drive_service->getChildrenForDriveItem($drive->getId(),$id);//idItem: PROJET
                }
                else
                   $itemChildren= $drive_service->getChildrenForDrive($drive->getId());

                //dump($itemChildren);
                //die();
                
            $data=[];


            foreach($itemChildren as $child){

                $item=[
                    'id'=>$child->getId(),
                    'text'=>$child->getName()
                ];

                if($child->getFolder()!=null){
                    $item['children']=true;
                    $item['type']="folder";
                    $item['state'] = [
                    'opened' => false,
                    'selected' => false
                    ];

                }else{
                    $ext= pathinfo($child->getName())['extension'];

                    $item['webUrl']=$child->getWebUrl();
                    $item['type']=$ext;
                }
                $data[]=$item;

            }   
            $resp= [
                'text'=>"racine",
                'children'=>$data
                ];

                //dump($firstChild);
            
            return new JsonResponse($data);

        
                
        }catch(\Exception $ex){
            dump($ex->getMessage());
            die();
        }
   }

    
}
