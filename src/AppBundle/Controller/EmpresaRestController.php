<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class EmpresaRestController extends FOSRestController
{

    public function getEmpresaAction(Request $request)
    {
        $empresas = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findBy(array('activo'=>true));

        $vista = $this->view($empresas,
            200)
        ;

        return $this->handleView($vista);

    }

}
