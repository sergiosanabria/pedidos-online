<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CategoriasRestController extends FOSRestController {

    public function getCategoriasAction(Request $request) {

        $categorias = $this->getDoctrine()->getRepository("AppBundle:Categoria")->findAll();

        $vista = $this->view( $categorias,
            200 )
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView( $vista );
    }
}
