<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events as EV;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 * @UniqueEntity("id")
 * @UniqueEntity("numero")
 * @ORM\HasLifecycleCallbacks
 */
class Pedido
{
    public function __construct() {
        $this->itensPedido = new ArrayCollection();
        //$this->numero = $this->getProximoNumero();
    }
    
    /*----- ATRIBUTOS -----*/
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;
    
    /**
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true)
     */    
    private $numero;
    
    
    /**
     * Um Pedido tem um cliente.
     * @ORM\OneToOne(targetEntity="Pessoa")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */    
    private $cliente;
    
    /** 
     * @ORM\Column(type="date", name="dataemissao") 
     * @Assert\NotBlank()
     */    
    private $emissao;    
    
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $total;      
    
    /**
     * Um Pedido tem muitos ItemPedido.
     * @ORM\OneToMany(targetEntity="App\Entity\ItemPedido", mappedBy="Pedido")
     * @Assert\NotBlank()
     */    
    private $itensPedido;    
    
    /*----- GETTERS -----*/    
    
    public function getId() {
        return $this->id;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getEmissao() {
        return $this->emissao;
    }

    public function getTotal() {
        return $this->total;
    }

    /**
     * @return Collection|ItemPedido[]
     */    
    public function getItensPedido() {
        return $this->itensPedido;
    }

    /*----- SETTERS -----*/

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function setEmissao($emissao) {
        $this->emissao = $emissao;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setItensPedido($itensPedido) {
        $this->itensPedido = $itensPedido;
    }
    
    /*----- -----*/

    public function addItemPedido(ItemPedido $itemPedido)
    {
        if ($this->itensPedido->contains($itemPedido)) {
            return;
        }

        $itemPedido->setPedido($this);
        $this->itensPedido[] = $itemPedido;
    }    
    
    /**
     * Evento disparado antes de persistir o objeto, para gerar o numero.
     * Fonte: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html
     * @ORM\PrePersist
     */
    public function setNumeroValue( \Doctrine\ORM\Event\LifecycleEventArgs $event ) {
        $em = $event->getEntityManager();
        $repository = $em->getRepository( get_class($this) );
        
        $iProximoNumero = $repository->getProximoNumero();
        
        $this->setNumero($iProximoNumero);
    }    
    
  
    
}
