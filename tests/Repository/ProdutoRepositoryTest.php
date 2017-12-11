<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Produto;


/**
 * Testes unitários para o repositório de Produto.
 *
 * @author marcosvha
 */
class ProdutoRepositoryTest extends KernelTestCase 
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
        
        parent::setUp();        
    }    
    
    public function testFindByNome()
    {
        // Inserido no AppFixtures
        $produtos = $this->em
            ->getRepository(Produto::class)
            ->findByNome('Produto XYZ') 
        ; 

        $this->assertCount(1, $produtos);
    }
    
    public function testFindByNomeParcial()
    {
        $produtos = $this->em
            ->getRepository(Produto::class)
            ->findByNome('XYZ') 
        ; 

        $this->assertCount(2, $produtos);
    }    
    
    public function testFindByCodigo()
    {
        $produtos = $this->em
            ->getRepository(Produto::class)
            ->findByCodigo('XYZ123')
        ;

        $this->assertCount(1, $produtos);
    }    

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; 
    }
}
