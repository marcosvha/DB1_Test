<?php
namespace App\Controller;

use App\Entity\Pedido;
use App\Entity\Pessoa;
use App\Entity\Produto;
use App\Entity\ItemPedido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PedidoController extends Controller
{
    
     /**
      * @Route("/pedido/add")
      */    
    public function add(Request $request)
    {
        $oPedido = new Pedido();
        $oPedido->setEmissao(new \DateTime('today'));
        $oPedido->setTotal(1);
        
        
        $form = $this->createFormBuilder($oPedido)
            ->add('cliente', EntityType::class, array(
                'class' => Pessoa::class,
                'label' => 'Cliente',
                'choice_label' => 'nome',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),                
            ))
            ->add('emissao', DateType::class, array(
                'widget' => 'choice',
                'label' => 'Emissão',                
                'attr' => array(
                    'class' => 'form-control'
                ),                 
            ))                
                
            /*    
            ->add('itensPedido', CollectionType::class, array(
                'entry_type'   => ChoiceType::class,
                'entry_options' => // Aqui não consegui encontrar como fazer  ,
                'required' => true,
                'multiple' => true,
                'label' => 'Itens',
                
                'attr' => array(
                    'class' => 'form-control'
                ),                
            ))                
            */
                
            ->add('save', SubmitType::class, array(
                'label' => 'Salvar pedido',
                'attr' => array('class' => 'btn btn-primary pull-right'),                
            ))
            ->getForm();        
        
        $form->handleRequest($request);    
        
        if ($form->isSubmitted() && $form->isValid()) {
            $oPedido = $form->getData();
            
            
            /* Este trecho tive que fazer hard coded, não consegui finalizar */
            $em = $this->getDoctrine()->getManager();
            
            $oFakeProduto = new Produto();
            $oFakeProduto->setCodigo(uniqid(""));
            $oFakeProduto->setNome('Produto ' . $oFakeProduto->getCodigo());
            $oFakeProduto->setPrecoUnitario(199.99);
            $em->persist($oFakeProduto);
            
            $oFakeItemPedido = new ItemPedido();
            $oFakeItemPedido->setProduto($oFakeProduto);
            $oFakeItemPedido->setPrecoUnitario($oFakeProduto->getPrecoUnitario());
            $oFakeItemPedido->setQuantidade(1);
            $oFakeItemPedido->setTotal($oFakeProduto->getPrecoUnitario() * 1);
            $oFakeItemPedido->setPercentualDesconto(0);
            $oFakeItemPedido->setPedido($oPedido);
            
            $oPedido->addItemPedido($oFakeItemPedido);   //PROBLEMA: NÃO ESTÁ SETANDO O ID DO PEDIDO
            //$oPedido->setTotal($oFakeItemPedido->getTotal());
            $oPedido->setTotal(1);

            $em->persist($oFakeItemPedido);
            $em->persist($oPedido);
            $em->flush(); /* :( Não está salvando */

            return new Response(
                '<html><body>Pedido salvo com sucesso!</body></html>'
            );
        }        
        
        return $this->render('Pedido/pedido_detalhe.html.twig', array( 
            'form' => $form->createView()
        ));        
    }
}
