<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PedidoCabecera;
use AppBundle\Entity\PedidoItem;
use Doctrine\Common\Collections\ArrayCollection;
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
        $unPedido->setObservacion($pedido->get('observacion'));
        $unPedido->setEstado($pedido->get('estado'));

        $totalPedido = 0;

        foreach ($pedido->get('items') as $item) {
            $unItem = new PedidoItem();
            $unItem->setCantidad($item['cantidad']);
            $unItem->setDetalles($item['detalle']);
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

    public function putPedidoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $pedido = $request->request;

        $unPedido = $this->getDoctrine()->getRepository("AppBundle:PedidoCabecera")->find($id);

        $arrayItemsOriginal = new ArrayCollection();
        $arrayIdsItemsActivos = array();

        foreach ($unPedido->getItemsActivos() as $itemsActivo) {
            $arrayItemsOriginal->add($itemsActivo);
        }


        $unPedido->setDelivery($pedido->get('delivery'));
        $unPedido->setObservacion($pedido->get('observacion'));
        $unPedido->setEstado($pedido->get('estado'));

        $totalPedido = 0;

        foreach ($pedido->get('items') as $item) {

            if ($item['id'] == -1) {
                $unItem = new PedidoItem();
            } else {
                $unItem = $this->getDoctrine()->getRepository("AppBundle:PedidoItem")->find($item['id']);
                $arrayIdsItemsActivos [] = $item['id'];
            }

            $unItem->setCantidad($item['cantidad']);
            $unItem->setDetalles($item['detalle']);
            $unProducto = $em->getRepository("AppBundle:Producto")->find($item['producto']['id']);
            $unItem->setProducto($unProducto);
            $unItem->setPrecio($unProducto->getPrecioDeVenta());
            $totalItem = $unItem->calcularTotal();

            if ($item['id'] == -1) {
                $unItem->setPedidoCabecera($unPedido);

                $unPedido->addPedidosItem($unItem);
            }


            $totalPedido += $totalItem;

        }

        foreach ($arrayItemsOriginal as $item) {
            if (!in_array($item->getId(), $arrayIdsItemsActivos)) {
                $item->setActivo(false);
            }
        }

        $unPedido->setTotal($totalPedido);

        //$em->persist($unPedido);

        $em->flush();


        $vista = $this->view($pedido,
            200)
//			->setTemplate( "MyBundle:Users:getUsers.html.twig" )
//			->setTemplateVar( 'noticias' )
        ;

        return $this->handleView($vista);
    }
}
