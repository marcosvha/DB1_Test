<?php
namespace App\Controller;

use App\Entity\Pessoa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PessoaController extends Controller
{
    
     /**
      * @Route("/pessoa/add")
      */    
    public function add(Request $request)
    {
        $oPessoa = new Pessoa();
        
        $form = $this->montaForm($oPessoa);
        
        $form->handleRequest($request);    
        
        if ($form->isSubmitted() && $form->isValid()) {
            $oPessoa = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($oPessoa);
            $em->flush(); 

            return new Response(
                '<html><body>Pessoa salva com sucesso!</body></html>'
            );
        }        
        
        return $this->render('Pessoa/pessoa_detalhe.html.twig', array( 
            'form' => $form->createView()
        ));        
    }
    
     /**
      * @Route("/pessoa/edit/{id}")
      */       
    public function edit($id, Request $request)
    {
        $oPessoa = $this->getDoctrine()
            ->getRepository(Pessoa::class)
            ->find($id);
        if (isset($oPessoa)) 
        {
            $form = $this->montaForm($oPessoa);

            $form->handleRequest($request);    

            if ($form->isSubmitted() && $form->isValid()) {
                $oPessoa = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($oPessoa);
                $em->flush(); 

                return new Response(
                    '<html><body>Pessoa salva com sucesso!</body></html>'
                );
            }        

            return $this->render('Pessoa/pessoa_detalhe.html.twig', array( 
                'form' => $form->createView()
            ));        
        }
        else 
        {
            return new Response(
                '<html><body>Pessoa não encontrada. ID = ' . $id . '</body></html>'
            );
        }
    }
    
     /**
      * @Route("/pessoa/view/{id}")
      */    
    public function view($id, Request $request)
    {
        $oPessoa = $this->getDoctrine()
            ->getRepository(Pessoa::class)
            ->find($id);
        if (isset($oPessoa)) {
            $form = $this->montaForm($oPessoa, true);

            $form->handleRequest($request);              
            
            if ($form->isSubmitted()) {

                return new Response(
                    '<html><body>A ideia aqui é voltar para a página anterior... (falta implementar)</body></html>'
                );
            }        

            return $this->render('Pessoa/pessoa_detalhe.html.twig', array( 
                'form' => $form->createView()
            ));        
        }
        else 
        {
            return new Response(
                '<html><body>Pessoa não encontrada. ID = ' . $id . '</body></html>'
            );
        }
    }    
    
     /**
      * @Route("/pessoa/delete/{id}")
      */    
    public function delete($id)
    {
        $oPessoa = $this->getDoctrine()
            ->getRepository(Pessoa::class)
            ->find($id);
        if (isset($oPessoa)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($oPessoa);
            $em->flush(); 
            
            return new Response(
                '<html><body>Pessoa excluída.</body></html>'
            );
        }
        else 
        {
            return new Response(
                '<html><body>Pessoa não encontrada. ID = ' . $id . '</body></html>'
            );
        }
    }      
    
    /**
     * 
     * @param Pessoa $pessoa
     * @param bool $readOnly
     */
    private function montaForm($pessoa, $readOnly = false)
    {    
        $form = $this->createFormBuilder($pessoa)
            ->add('nome', TextType::class, array(
                'required' => true,
                'disabled' => $readOnly === true ? true : false,
                'attr' => array('class' => 'form-control'),                 
            ))                
            ->add('dataNascimento', BirthdayType::class, array(
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
