<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PessoaRepository")
 * @UniqueEntity("id")
 * @UniqueEntity("nome")
 */
class Pessoa
{
    /*----- ATRIBUTOS -----*/
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $nome;

    /** 
     * @ORM\Column(type="date", name="datanascimento") 
     * @Assert\NotBlank()
     * @Assert\LessThanOrEqual("today")
     */
    private $dataNascimento;
    
    /*----- GETTERS -----*/
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    /*----- SETTERS -----*/

    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * 
     * @param string $dataNascimentoString formato d/m/Y
     */
    public function setDataNascimentoDMY($dataNascimentoString) {
        $dataNascimento = date_create_from_format("d/m/Y", ($dataNascimentoString));
        $this->setDataNascimento($dataNascimento);
    }
    
    /**
     * 
     * @param DateTime $dataNascimento
     */
    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }
    
}
