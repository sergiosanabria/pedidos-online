<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PedidoCabecera;
use AppBundle\Entity\PedidoItem;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class PedidosRestController extends FOSRestController
{

    public function getPedidosAction(Request $request)
    {

        $pedidos = $this->getDoctrine()->getRepository("AppBundle:PedidoCabecera")->getPedidos();

        $vista = $this->view($pedidos,
            200)
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView($vista);
    }

    public function getPedidoAction(Request $request, $id)
    {

        $pedido = $this->getDoctrine()->getRepository("AppBundle:PedidoCabecera")->find($id);

        $vista = $this->view($pedido,
            200)
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView($vista);
    }


    public function postPedidoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pedido = $request->request;

        $unPedido = new PedidoCabecera();

        $unPedido->setDelivery($pedido->get('delivery'));
        $unPedido->setObservacion($pedido->get('obs'));
        $unPedido->setEstado($pedido->get('estado'));

        $totalPedido = 0;

        foreach ($pedido->get('items') as $item) {
            $unItem = new PedidoItem();
            $unItem->setCantidad($item['cantidad']);
            $unItem->setDetalles($item['obs']);
            $unProducto = $em->getRepository("AppBundle:Producto")->find($item['producto']['id']);
            $unItem->setProducto($unProducto);
            $unItem->setPrecio($unProducto->getPrecioDeVenta());
            $totalItem = $unItem->calcularTotal();

            $unItem->setPedidoCabecera($unPedido);

            $unPedido->addPedidosItem($unItem);

            $totalPedido += $totalItem;

        }

        $unPedido->setTotal($totalPedido);

        $em->persist($unPedido);

        $em->flush();


        $vista = $this->view($pedido,
            200)
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView($vista);
    }
}
