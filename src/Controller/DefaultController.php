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
        
        try{
                $client= $this->get('microsoft_graph.client');
                $client->getNewToken();
        }catch(\Exception $ex){
               $client->redirect();
        }

                $sharepoint= $this->get('microsoft_graph.sharepoint');
                $cal= $this->get('microsoft_graph.calendar');
        try{

                dump($cal->getEvents(new DateTime("last month"), new DateTime("next month")));

                // get Root
                $root= $sharepoint->getRoot();

                dump("Root");
                dump($root->jsonSerialize());

                // get List of root (site)

                dump("List of root (site)");
                $list =$sharepoint->getListsOfSite($root->getId());
                dump($list->getBody());

                $documents=null;
                foreach($list as $item){

                    if($item->getName()=='Documents')
                    {
                         $documents = $item;
                         break;
                    }
                }


                // get Document information 
                dump("Document information ");
                dump($documents->jsonSerialize());


                // get subsites of root

                dump("get subsites of root");
                $subsites= $sharepoint->getSubsitesOfSite($root->getId());
                dump($subsites->jsonSerialize());

                // get Meta data
                 dump(" Meta data");
                $meta = $sharepoint->getMetaDataOfList($root->getId(),$documents->getId());
                dump($meta->jsonSerialize());


                // get items of documents
                dump(" items of documents");
                $items=$sharepoint->getItemsOfList($root->getId(),$documents->getId());

        }catch(\Exception $ex){
            dump($ex);
        }

        die();
        return $this->render('MicrosoftGraphBundle:Default:index.html.twig');
       

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
            
            
            $token=$client->getAccessToken();

             $storage_manager= $this->getParameter("microsoft_graph")["storage_manager"];
             $tokenStorage =$this->get($storage_manager);

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
