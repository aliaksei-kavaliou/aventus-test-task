<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoadScheduler
 *
 * @ORM\Table(name="load_scheduler")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoadSchedulerRepository")
 */
class LoanPayment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="date")
     */
    private $paymentDate;

    /**
     * @var float
     *
     * @ORM\Column(name="main_debt", type="float")
     */
    private $mainDebt;

    /**
     * @var float
     *
     * @ORM\Column(name="interest", type="float")
     */
    private $interest;

    /**
     * @var float
     *
     * @ORM\Column(name="payed", type="float")
     */
    private $payed;

    /**
     * @var float
     *
     * @ORM\Column(name="remain", type="float")
     */
    private $remain;

    /**
     *
     * @var Loan
     * @ORM\ManyToOne(targetEntity="Loan", inversedBy="payments")
     */
    private $loan;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return LoanPayment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set mainDebt
     *
     * @param float $mainDebt
     *
     * @return LoanPayment
     */
    public function setMainDebt($mainDebt)
    {
        $this->mainDebt = $mainDebt;

        return $this;
    }

    /**
     * Get mainDebt
     *
     * @return float
     */
    public function getMainDebt()
    {
        return $this->mainDebt;
    }

    /**
     * Set interest
     *
     * @param float $interest
     *
     * @return LoanPayment
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return float
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set payed
     *
     * @param float $payed
     *
     * @return LoanPayment
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;

        return $this;
    }

    /**
     * Get payed
     *
     * @return float
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Set remain
     *
     * @param float $remain
     *
     * @return LoanPayment
     */
    public function setRemain($remain)
    {
        $this->remain = $remain;

        return $this;
    }

    /**
     * Get remain
     *
     * @return float
     */
    public function getRemain()
    {
        return $this->remain;
    }

    /**
     * Set loan
     *
     * @param \AppBundle\Entity\Loan $loan
     *
     * @return LoanPayment
     */
    public function setLoan(\AppBundle\Entity\Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return \AppBundle\Entity\Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }
}
