<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class RepartidorRestController extends FOSRestController
{

    public function getRepartidorAction(Request $request)
    {

        $repartidores = $this->getDoctrine()->getRepository("AppBundle:Repartidor")->getRepartidoresActivos();

        $vista = $this->view($repartidores,
            200)
        ;

        return $this->handleView($vista);

    }




}
