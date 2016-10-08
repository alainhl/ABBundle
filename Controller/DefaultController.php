<?php

namespace AB\ABBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function processScoreAction(Request $request) {
        
        //getting the parameters
        $strTestSuite = $this->getRequest()->get('test_suite');
        $intScore = (int)$this->getRequest()->get('score');
        
        $objAB = $this->get('ab');
        $objManager = $objAB->getManager();
        
        try {
            
            //let's now get the test suite
            switch ($strTestSuite) {
                case 'menu-item-templates':
                    $this->getMenuItemTemplatesTestSuite($strTestSuite, $objManager); 
                    break;
                
                case 'menu-item-resources':
                    $this->getMenuItemResourcesTestSuite($strTestSuite, $objManager); 
                    break;

                default:
                    throw new \Exception(printf('Do not know how to process test suite: %s', $strTestSuite));
                    break;
            }

            if($intScore > 0)
            {
                $objAB->addScore(+$intScore, $strTestSuite);
            }
            else
            {
                throw new \Exception(printf('Do not know how to process score: %s', $intScore));
            }

            $response = new Response();
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent('OK');
            return $response;
            
        } catch (\Exception $exc) {
            
            $response = new Response();
            $response->setStatusCode(400);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
    
   /**
    * Create or get a test suite 
    * @param type $strTestSuite
    * @param type $objManager
    * @return $objTestSuite
    */
   private function getMenuItemTemplatesTestSuite($strTestSuite, $objManager)
   {
        $objTestSuite = $objManager->getTestSuite($strTestSuite);
        
        //if the test suite does not exist, create it
        if(!$objTestSuite)
        {
            $objTestSuite = $objManager->newTestSuite('menu-item-templates'); // Default versions: A and B
            $objTestSuite->addReplacements('A', array('label' => 'nav.templates_a')); // Version A
            $objTestSuite->addReplacements('B', array('label' => 'nav.templates_b'));     // Version B
            $objManager->persist($objTestSuite);
        }
        
        return $objTestSuite; 
   }
   
   /**
    * Create or get a test suite 
    * @param type $strTestSuite
    * @param type $objManager
    * @return type
    */
   private function getMenuItemResourcesTestSuite($strTestSuite, $objManager)
   {
        $objTestSuite = $objManager->getTestSuite($strTestSuite);
        
        //if the test suite does not exist, create it
        if(!$objTestSuite)
        {
            $objTestSuite = $objManager->newTestSuite('menu-item-resources'); // Default versions: A and B
            $objTestSuite->addReplacements('A', array('label' => 'nav.resources_a'));     // Version A
            $objTestSuite->addReplacements('B', array('label' => 'nav.resources_b'));     // Version B
            $objManager->persist($objTestSuite);
        }
        
        return $objTestSuite; 
   }
}
