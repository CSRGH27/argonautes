<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArgonauteController extends AbstractController
{
    public $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="argonaute", methods={"GET", "HEAD"})
     * 
     */
    public function index(Request $request)
    {

        $argonautes = $this->getDoctrine()->getRepository(Argonaute::class)->findAll();



        return $this->render('argonaute/index.html.twig', [
            'controller_name' => 'ArgonauteController',
            'argos' => $argonautes,


        ]);
    }

    /**
     * @Route("/", name="argonaute")
     *
     */
    public function newArgonaute(Request $request)
    {
        $argonautes = $this->getDoctrine()->getRepository(Argonaute::class)->findAll();
        $argonaute = new Argonaute;
        $form = $this->createForm(ArgonauteType::class, $argonaute);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->persist($argonaute);
            $this->em->flush();
            dump("test");
            return $this->redirectToRoute('argonaute');
        }

        return $this->render('argonaute/index.html.twig', [
            'form' => $form->createView(),
            'argos' => $argonautes,
        ]);
    }
}
