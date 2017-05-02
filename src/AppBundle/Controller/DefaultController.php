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
     * @Route("/loan", name="loan_calculator")
     */
    public function loanAction(Request $request)
    {
        $loan = null;
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(\AppBundle\Form\LoanType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $calc \AppBundle\Service\LoanCalculator */
            $calc = $this->get('app.loan_calculator');
            $calc->setAmount($form->getData()->getAmount())
                ->setPeriod($form->getData()->getPeriod())
                ->setRate($form->getData()->getRate() / 100)
                ->setFirstPayment($form->getData()->getFirstPayment());
            $payments = $calc->calculate();

            $loan = new \AppBundle\Entity\Loan();
            $loan->setAmount($form->getData()->getAmount())
                ->setFirstPayment($form->getData()->getFirstPayment())
                ->setPeriod($form->getData()->getPeriod())
                ->setRate($form->getData()->getRate());

            foreach ($payments as $p) {
                $payment = new \AppBundle\Entity\LoanPayment();
                $payment->setInterest($p['interest'])
                    ->setMainDebt($p['mainDebt'])
                    ->setPayment($p['payment'])
                    ->setPaymentDate($p['date'])
                    ->setRemain($p['debt']);
                $loan->addPayment($payment);
            }

            $em->persist($loan);
            $em->flush();
        }

        return $this->render('default/loan.html.twig', [
            'form' => $form->createView(),
            'loan' => $loan,
        ]);
    }
}
