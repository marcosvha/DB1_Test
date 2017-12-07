<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemPedidoRepository")
 * @UniqueEntity("id")
 */
class ItemPedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;

    /**
     * Um ItemPedido referencia um Produto.
     * @ORM\OneToOne(targetEntity="Produto")
     * @ORM\JoinColumn(name="produto_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */    
    private $produto;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */    
    private $quantidade;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $precoUnitario;    
    
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $percentualDesconto;    
     
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $total;    
    
    /**
     * Muitos ItemPedido pertencem a um Pedido.
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="itensPedido")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $pedido;    
 
    /*----- GETTERS -----*/    
    
    public function getId() {
        return $this->id;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getPrecoUnitario() {
        return $this->precoUnitario;
    }

    public function getPercentualDesconto() {
        return $this->percentualDesconto;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getPedido() {
        return $this->pedido;
    }
    
    /*----- SETTERS -----*/    

    public function setProduto($produto) {
        $this->produto = $produto;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function setPrecoUnitario($precoUnitario) {
        $this->precoUnitario = $precoUnitario;
    }

    public function setPercentualDesconto($percentualDesconto) {
        $this->percentualDesconto = $percentualDesconto;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    
    
}
