<?php
namespace App\DataFixtures;

use App\Entity\Produto;
use App\Entity\Pessoa;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Insere 10 produtos
        for ($i = 1; $i <= 10; $i++) {
            $oProduto = new Produto();
            $oProduto->setNome('Produto ' . $i);
            $oProduto->setPrecoUnitario(mt_rand(100, 1000));
            $oProduto->setCodigo($i);
            $manager->persist($oProduto);
        }        
        
        // Insere 3 pessoas
        for ($i = 1; $i <= 3; $i++) {
            $oPessoa = new Pessoa();
            $oPessoa->setNome('Pessoa ' . $i);
            $oPessoa->setDataNascimentoDMY('05/01/2000');
            $manager->persist($oPessoa);
        }        
        
        $manager->flush();        
    }
}
