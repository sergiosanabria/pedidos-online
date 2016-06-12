<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CombosRestController extends FOSRestController {

    public function getCombosAction(Request $request) {

        $combos = $this->getDoctrine()->getRepository("AppBundle:Combo")->findAll();

        $vista = $this->view( $combos,
            200 )
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView( $vista );
    }
}
