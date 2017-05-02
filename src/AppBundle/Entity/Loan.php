<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loan
 *
 * @ORM\Table(name="loan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanRepository")
 */
class Loan
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
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     */
    private $rate;

    /**
     * @var int
     *
     * @ORM\Column(name="period", type="integer")
     */
    private $period;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="first_payment", type="date")
     */
    private $firstPayment;

    /**
     *
     * @var LoanPayment[]
     * @ORM\OneToMany(targetEntity="LoanPayment", mappedBy="loan", cascade={"persist", "remove"})
     */
    private $payments;


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
     * Set amount
     *
     * @param float $amount
     *
     * @return Loan
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return Loan
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return Loan
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set firstPayment
     *
     * @param \DateTime $firstPayment
     *
     * @return Loan
     */
    public function setFirstPayment($firstPayment)
    {
        $this->firstPayment = $firstPayment;

        return $this;
    }

    /**
     * Get firstPayment
     *
     * @return \DateTime
     */
    public function getFirstPayment()
    {
        return $this->firstPayment;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add payment
     *
     * @param \AppBundle\Entity\LoanPayment $payment
     *
     * @return Loan
     */
    public function addPayment(\AppBundle\Entity\LoanPayment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param \AppBundle\Entity\LoanPayment $payment
     */
    public function removePayment(\AppBundle\Entity\LoanPayment $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
