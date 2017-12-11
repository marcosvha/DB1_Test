<?php
namespace App\Controller;

use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProdutoController extends Controller
{
    
    /**
     * @Route("/") 
     * @Route("/produto")
     * @Route("/produto/listar")
     */    
    public function listar($mensagem = '')
    {
        $em = $this->getDoctrine()->getManager();
        $produtos = $em->getRepository('App\Entity\Produto')->findAll();
        
        return $this->render('Produto/produto_lista.html.twig', array( 
            'produtos' => $produtos,
            'mensagem' => $mensagem
        ));        
    }    
    
    /**
     * @Route("/produto/add")
     */    
    public function add(Request $request)
    {
        $oProduto = new Produto();
        
        $form = $this->montaForm($oProduto);
        
        $form->handleRequest($request);    
        $mensagem = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $oProduto = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($oProduto);
            $em->flush(); 

            $mensagem = 'Produto salvo com sucesso!';
        }        
        
        return $this->render('Produto/produto_detalhe.html.twig', array( 
            'form' => $form->createView(),
            'mensagem' => $mensagem
            
        ));        
    }
    
    /**
     * @Route("/produto/edit/{id}")
     */       
    public function edit($id, Request $request)
    {
        $oProduto = $this->getDoctrine()
            ->getRepository(Produto::class)
            ->find($id);
        $mensagem = '';
        if (isset($oProduto)) 
        {
            $form = $this->montaForm($oProduto);

            $form->handleRequest($request);    

            if ($form->isSubmitted() && $form->isValid()) {
                $oProduto = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($oProduto);
                $em->flush(); 
                
                $mensagem = 'Produto salvo com sucesso!';
            }        

            return $this->render('Produto/produto_detalhe.html.twig', array( 
                'form' => $form->createView(),
                'mensagem' => $mensagem
            ));        
        }
        else 
        {
           return $this->listar('Produto não encontrado. ID = ' . $id); 
        }
    }
    
    /**
     * @Route("/produto/view/{id}")
     */    
    public function view($id, Request $request)
    {
        $oProduto = $this->getDoctrine()
            ->getRepository(Produto::class)
            ->find($id);
        if (isset($oProduto)) {
            $form = $this->montaForm($oProduto, true);

            $form->handleRequest($request);              
            
            if ($form->isSubmitted()) {
                return $this->listar(); 
            }        

            return $this->render('Produto/produto_detalhe.html.twig', array( 
                'form' => $form->createView()
            ));        
        }
        else 
        {
           return $this->listar('Produto não encontrado. ID = ' . $id); 
        }
    }    
    
    /**
     * @Route("/produto/delete/{id}")
     */    
    public function delete($id)
    {
        $oProduto = $this->getDoctrine()
            ->getRepository(Produto::class)
            ->find($id);
        if (isset($oProduto)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($oProduto);
            $em->flush(); 
            
           return $this->listar('Produto excluído.'); 
       
        }
        else 
        {
           return $this->listar('Produto não encontrado. ID = ' . $id); 
        }
    }      
    
    /**
     * 
     * @param Produto $produto
     * @param bool $readOnly
     */
    private function montaForm($produto, $readOnly = false)
    {    
        $form = $this->createFormBuilder($produto)
            ->add('codigo', TextType::class, array(
                'label' => 'Código',
                'required' => true,
                'disabled' => $readOnly === true ? true : false,
                'attr' => array('class' => 'form-control'),                
            ))
            ->add('nome', TextType::class, array(
                'required' => true,
                'disabled' => $readOnly === true ? true : false,
                'attr' => array('class' => 'form-control'),                 
            ))                
            ->add('precoUnitario', MoneyType::class, array(
                'currency'=>'BRL',
                'required' => true,
                'disabled' => $readOnly === true ? true : false,
                'attr' => array('class' => 'form-control'),                 
            ))
            ->add('save', SubmitType::class, array(
                'label' => $readOnly === true ? 'Voltar' : 'Salvar',
                'attr' => array('class' => 'btn btn-primary pull-right'),                
            ))
            ->getForm(); 
        
        return $form;
    }        
}
