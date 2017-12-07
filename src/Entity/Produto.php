<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProdutoRepository")
 * @UniqueEntity("id")
 * @UniqueEntity("codigo")
 * @UniqueEntity("nome")
 */
class Produto
{
    /*----- ATRIBUTOS -----*/
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $codigo;
    
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $nome;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $precoUnitario;  
    
    /*----- GETTERS -----*/
    public function getId() {
        return $this->id;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPrecoUnitario() {
        return $this->precoUnitario;
    }

    /*----- SETTERS -----*/
    
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setPrecoUnitario($precoUnitario) {
        $this->precoUnitario = $precoUnitario;
    }
    
}
