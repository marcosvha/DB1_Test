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
      * @Route("/produto/add")
      */    
    public function add(Request $request)
    {
        $oProduto = new Produto();
        
        $form = $this->montaForm($oProduto);
        
        $form->handleRequest($request);    
        
        if ($form->isSubmitted() && $form->isValid()) {
            $oProduto = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($oProduto);
            $em->flush(); 

            return new Response(
                '<html><body>Produto salvo com sucesso!</body></html>'
            );
        }        
        
        return $this->render('Produto/produto_detalhe.html.twig', array( 
            'form' => $form->createView()
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
        if (isset($oProduto)) 
        {
            $form = $this->montaForm($oProduto);

            $form->handleRequest($request);    

            if ($form->isSubmitted() && $form->isValid()) {
                $oProduto = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($oProduto);
                $em->flush(); 

                return new Response(
                    '<html><body>Produto salvo com sucesso!</body></html>'
                );
            }        

            return $this->render('Produto/produto_detalhe.html.twig', array( 
                'form' => $form->createView()
            ));        
        }
        else 
        {
            return new Response(
                '<html><body>Produto não encontrado. ID = ' . $id . '</body></html>'
            );
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
                'label' => $readOnly === true ? 'Fechar' : 'Salvar',
                'attr' => array('class' => 'btn btn-primary pull-right'),                
            ))
            ->getForm(); 
        
        return $form;
    }        
}
