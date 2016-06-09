<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class PedidosRestController extends FOSRestController {

    public function getPedidosAction(Request $request) {

        $pedidos = $this->getDoctrine()->getRepository("AppBundle:PedidoCabecera")->getPedidos();

        $vista = $this->view( $pedidos,
            200 )
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView( $vista );
    }
}
