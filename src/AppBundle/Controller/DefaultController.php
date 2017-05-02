<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/chess/board", name="chess_board")
     */
    public function chessBoardAction()
    {
        return $this->render('default/chess.board.html.twig');
    }

    /**
     * Loan calculator gui
     * @param Request $request
     * @return Response
     */
    public function loanAction(Request $request)
    {
        $form = $this->createForm(\AppBundle\Form\LoanType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calc = $this->get('loan_calculator');
            $calc->setAmount($form->getData()->getAmount())
                ->setPeriod($form->getData()->getPeriod())
                ->setRate($form->getData()->getRate());
        }
    }
}
