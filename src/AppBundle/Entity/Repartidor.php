<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Repartidor
 *
 * @ORM\Table(name="repartidor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepartidorRepository")
 * @ExclusionPolicy("all")
 *
 */
class Repartidor extends BaseClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    private $id;

    /**
     * @var string
     * @Expose()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     * @Expose()
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=10, nullable=true)
     */
    private $dni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNaciemiento", type="datetime", nullable=true)
     */
    private $fechaNaciemiento;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PedidoCabecera", mappedBy="repartidor")
     */
    private $pedidos;


    public function __toString()
    {
        return $this->apellido.' '.$this->nombre;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Repartidor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Repartidor
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Repartidor
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set fechaNaciemiento
     *
     * @param \DateTime $fechaNaciemiento
     *
     * @return Repartidor
     */
    public function setFechaNaciemiento($fechaNaciemiento)
    {
        $this->fechaNaciemiento = $fechaNaciemiento;

        return $this;
    }

    /**
     * Get fechaNaciemiento
     *
     * @return \DateTime
     */
    public function getFechaNaciemiento()
    {
        return $this->fechaNaciemiento;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Repartidor
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return Repartidor
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Add pedido
     *
     * @param \AppBundle\Entity\PedidoCabecera $pedido
     *
     * @return Repartidor
     */
    public function addPedido(\AppBundle\Entity\PedidoCabecera $pedido)
    {
        $this->pedidos[] = $pedido;

        return $this;
    }

    /**
     * Remove pedido
     *
     * @param \AppBundle\Entity\PedidoCabecera $pedido
     */
    public function removePedido(\AppBundle\Entity\PedidoCabecera $pedido)
    {
        $this->pedidos->removeElement($pedido);
    }

    /**
     * Get pedidos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Repartidor
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return Repartidor
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
