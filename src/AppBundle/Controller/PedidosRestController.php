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

        $arrayReturn = array();

        /**
         * @var $pedido PedidoCabecera
         */
        foreach ($pedidos as $pedido) {
            $arrayReturn [] = array(
                'estado' => $pedido->getEstado(),
                'id' => $pedido->getId(),
                'observacion' => $pedido->getObservacion(),
                'fechaCreacion' => date_format($pedido->getFechaCreacion(), 'Y-m-d H:i:s'),
                'total' => $pedido->getTotal(),
                'delivery' => $pedido->getDelivery(),
                'repartidor' => $pedido->getRepartidor()?$pedido->getRepartidor()->__toString():'',
            );
        }

        $vista = $this->view($arrayReturn,
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

            if ($item['producto']['isproducto']) {
                $unProducto = $em->getRepository("AppBundle:Producto")->find($item['producto']['id']);
                $unItem->setProducto($unProducto);
                $unItem->setPrecio($unProducto->getPrecioDeVenta());

            } else {
                $unProducto = $em->getRepository("AppBundle:Combo")->find($item['producto']['id']);
                $unItem->setCombo($unProducto);
                $unItem->setPrecio($unProducto->getPrecioVenta());
            }


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

        if ($pedido->get('estado') == 'cancelado' && $pedido->get('motivo_cancelacion_cliente')) {
            $unPedido->setMotivoCancelacionCliente($pedido->get('motivo_cancelacion_cliente'));
        }

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

            if ($item['producto']['isproducto']) {
                $unProducto = $em->getRepository("AppBundle:Producto")->find($item['producto']['id']);
                $unItem->setProducto($unProducto);
                $unItem->setPrecio($unProducto->getPrecioDeVenta());

            } else {
                $unProducto = $em->getRepository("AppBundle:Combo")->find($item['producto']['id']);
                $unItem->setCombo($unProducto);
                $unItem->setPrecio($unProducto->getPrecioVenta());
            }

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
