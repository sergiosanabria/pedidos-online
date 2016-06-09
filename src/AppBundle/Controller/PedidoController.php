<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PedidoController extends Controller
{
    public function indexAction()
    {
        $name = 'sergio';

        return $this->render('AppBundle:Pedido:index.html.twig', array('name' => $name));
    }


    public function ajaxGetPedidosAction(Request $request){
        $pedidos = $this->getDoctrine()->getRepository("AppBundle:PedidoCabecera")->getPedidos();

        return new JsonResponse($pedidos);
    }
}
