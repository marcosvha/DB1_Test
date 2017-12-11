<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Produto;
use App\DataFixtures\AppFixtures;


/**
 * Testes unitários para a entidade Produto.
 *
 * @author marcosvha
 */
class ProdutoTest extends KernelTestCase 
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     *
     * @var Doctrine 
     */
    private $doc;
    
    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->doc = $kernel->getContainer()
            ->get('doctrine');
        $this->em = $this->doc
            ->getManager();
        
        // ToDo: Como limpar os dados, como ocorre ao executar 'php bin/console doctrine:fixtures:load' ?
        //$appFixtures = new AppFixtures();
        //$appFixtures->load($this->em);
        
        parent::setUp();        
    }    
    
    public function testCreate() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Teclado');
        $oProduto->setPrecoUnitario(29.99);
        $oProduto->setCodigo('111111');
                
        $this->em->persist($oProduto);
        $this->em->flush();
        
        $this->assertNotEmpty($oProduto->getId());
    }    
    
    
    /**
     * @expectedException Doctrine\DBAL\Exception\UniqueConstraintViolationException
     */
    public function testCreateCodigoDuplicado() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Teclado');
        $oProduto->setPrecoUnitario(29.99);
        $oProduto->setCodigo('22222');
                
        $this->em->persist($oProduto);
        $this->em->flush();
        $this->assertNotEmpty($oProduto->getId());
        
        $oProduto2 = new Produto();
        $oProduto2->setNome('Mouse');
        $oProduto2->setPrecoUnitario(19.99);
        $oProduto2->setCodigo('22222');

        $this->em->persist($oProduto2);
        $this->em->flush(); // Exceção esperada: UniqueConstraintViolationException
        
        $this->assertEmpty($oProduto2->getId());
    }    
    
    /**
     * @expectedException Doctrine\DBAL\Exception\UniqueConstraintViolationException
     */    
    public function testCreateNomeDuplicado() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Notebook');
        $oProduto->setPrecoUnitario(2999.99);
        $oProduto->setCodigo('33333');
                
        $this->em->persist($oProduto);
        $this->em->flush();
        $this->assertNotEmpty($oProduto->getId());
        
        $oProduto2 = new Produto();
        $oProduto2->setNome('Notebook');
        $oProduto2->setPrecoUnitario(1999.99);
        $oProduto2->setCodigo('44444');

        $this->em->persist($oProduto2);
        $this->em->flush(); // Exceção esperada: UniqueConstraintViolationException
        
        $this->assertEmpty($oProduto2->getId());
    }    

    public function testRead1() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Monitor');
        $oProduto->setPrecoUnitario(399.99);
        $oProduto->setCodigo('55555');        
        
        $this->em->persist($oProduto);
        $this->em->flush();
        $this->assertNotEmpty($oProduto->getId());        
        
        $oProduto2 = $this->doc
                ->getRepository(Produto::class)
                ->find($oProduto->getId());
        
        $this->assertNotNull($oProduto2);
        $this->assertEquals('Monitor', $oProduto2->getNome());
        $this->assertEquals($oProduto->getNome(), $oProduto2->getNome());
    }
    
    public function testUpdate() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Impressora');
        $oProduto->setPrecoUnitario(299.99);
        $oProduto->setCodigo('66666');        
        
        $this->em->persist($oProduto);
        $this->em->flush();
        $this->assertNotEmpty($oProduto->getId());        

        // Altera o preço, usando o mesmo objeto
        $oProduto->setPrecoUnitario(259.99);
        $this->em->persist($oProduto);
        $this->em->flush();
        
        // Altera o nome, usando outro objeto
        $oProduto2 = $this->doc
                ->getRepository(Produto::class)
                ->find($oProduto->getId());
        // Valida a persistência da alteração de preço
        $this->assertEquals(259.99, $oProduto2->getPrecoUnitario());        
        
        $oProduto2->setNome('Impressora alterada');
        $this->em->flush();
        // Valida que não alterou o ID
        $this->assertEquals($oProduto->getId(), $oProduto2->getId());        

        $oProduto3 = $this->doc
                ->getRepository(Produto::class)
                ->find($oProduto2->getId());
        
        $this->assertNotNull($oProduto3);
        $this->assertEquals('Impressora alterada', $oProduto3->getNome());
        $this->assertEquals($oProduto->getNome(), $oProduto3->getNome());
    }
   
    public function testDelete() 
    {
        $oProduto = new Produto();
        $oProduto->setNome('Mesa');
        $oProduto->setPrecoUnitario(179.99);
        $oProduto->setCodigo('77777');        
        
        $this->em->persist($oProduto);
        $this->em->flush();
        $this->assertNotEmpty($oProduto->getId());     
        
        $oldId = $oProduto->getId();
        $this->assertNotNull($oldId);     
        
        $this->em->remove($oProduto);
        $this->em->flush();
        
        $oProduto2 = $this->doc
                ->getRepository(Produto::class)
                ->find($oldId);
        
        $this->assertNull($oProduto2);        
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; 
    }
}
