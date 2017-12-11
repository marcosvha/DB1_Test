<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Produto;


/**
 * Testes funcionais para a controller Produto.
 *
 * @author marcosvha
 */
class ProdutoControllerTest extends WebTestCase 
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
    
    public function testAdd() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/produto/add');
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Manter produto")')->count());        
        
        $form = $crawler->selectButton('form_save')->form();

        // set some values
        $form['form[codigo]'] = '12345';
        $form['form[nome]'] = 'Teste produto 12345';
        $form['form[precoUnitario]'] = '99,99';

        // submit the form
        $crawler = $client->submit($form);
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Produto salvo com sucesso!")')->count());        
    }    


    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; 
    }
}
