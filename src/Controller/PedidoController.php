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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PedidoController extends Controller
{
    
     /**
      * @Route("/pedido/add")
      */    
    public function add(Request $request)
    {
        $oPedido = new Pedido();
        
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
                'attr' => array('class' => 'btn btn-primary'),                
            ))
            ->getForm();        
        
        $form->handleRequest($request);    
        
        if ($form->isSubmitted() && $form->isValid()) {
            $oPedido = $form->getData();
            $oPedido->setEmissao(date("Y-m-d H:i:s"));
            
            /* Este trecho tive que fazer hard coded, não consegui finalizar */
            $em = $this->getDoctrine()->getManager();
            
            $oFakeProduto = new Produto();
            $oFakeProduto->setCodigo(uniqid(""));
            $oFakeProduto->setNome('Produto ' . $oFakeProduto->getCodigo());
            $oFakeProduto->setPrecoUnitario(rand(10, 1000));
            $em->persist($oFakeProduto);
            
            $oFakeItemPedido = new ItemPedido();
            $oFakeItemPedido->setProduto($oFakeProduto);
            $oFakeItemPedido->setPrecoUnitario($oFakeProduto->getPrecoUnitario());
            $oFakeItemPedido->setQuantidade(1);
            $oFakeItemPedido->setTotal($oFakeItemPedido->getPrecoUnitario() * $oFakeItemPedido->getQuantidade());
            $oFakeItemPedido->setPercentualDesconto(0);
            
            $oPedido->addItemPedido($oFakeItemPedido);
            $oPedido->setTotal($oFakeItemPedido->getTotal());

            $em->persist($oPedido);
            $em->flush(); /* :( Não está salvando */

            return new Response(
                '<html><body>Pedido salvo com sucesso!</body></html>'
            );
        }        
        
        return $this->render('Pedido/pedido_add.html.twig', array( 
            'form' => $form->createView()
        ));        
    }
}
