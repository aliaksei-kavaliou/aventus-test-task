<?php

namespace AppBundle\Service;

/**
 * Description of LoanCalculator
 *
 * @author aliaksei
 */
class LoanCalculator
{
    /**
     * Loan amount
     * @var float
     */
    private $amount;

    /**
     * Loan period months
     * @var int
     */
    private $period;

    /**
     * Loan rate 10% = 0.1
     * @var float
     */
    private $rate;

    /**
     * First payment date
     * @var \DateTime
     */
    private $firstPayment;

    /**
     * Set amount
     * @param float $amount
     * @return \AppBundle\Service\LoanCalculator
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set period
     * @param int $period
     * @return \AppBundle\Service\LoanCalculator
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Set rate
     * @param float $rate
     * @return \AppBundle\Service\LoanCalculator
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Set first payment date
     * @param \DateTime $firstPayment
     * @return \AppBundle\Service\LoanCalculator
     */
    public function setFirstPayment(\DateTime $firstPayment)
    {
        $this->firstPayment = $firstPayment;

        return $this;
    }


    /**
     * Calculates month payment
     * @return float
     */
    public function getMonthPayment($round = true)
    {
        $monthRate = $this->rate / 12;
        $amount = $this->amount * ($monthRate + $monthRate / (pow((1 + $monthRate), $this->period) - 1));

        if (!$round) {
            return $amount;
        }

        return round($amount, 2);
    }

    /**
     * Calculae payment scheduler
     * @return array
     */
    public function calculate()
    {
        $monthPayment = $this->getMonthPayment(false);

        $payments = [];
        $payed = 0;
        $date = clone $this->firstPayment;

        for ($i = 1; $i <= $this->period; $i++) {
            if ($i > 1) {
                $date = $this->nextMonth($date);
            }

            $payment = [
                'date' => $date,
                'payed' => round($payed, 2),
                'debt' => $this->amount - round($payed, 2),
            ];
            $interest = ($this->amount - $payed) * $this->rate / 12;
            $mainDebt = $monthPayment - $interest;
            $payed += $mainDebt;
            $payment['mainDebt'] = round($mainDebt, 2);
            $payment['interest'] = round($interest, 2);
            $payments[] = $payment;
        }

        return $payments;
    }

    /**
     * Get overpayments
     * @return float
     */
    public function getOverpayments()
    {
        $monthPayment = $this->getMonthPayment(false);

        return round($monthPayment * $this->period - $this->amount, 2);
    }

    /**
     * Get next month date
     * @param \DateTime $current
     * @return string
     */
    private function nextMonth($current)
    {
        $date = new \DateTime($current->format('Y-m-1'));
        $date->modify('+1 month');
        $day = $current->format('d');
        $daysInMonth = $date->format('t');

        if ($current->format('t') == $day || $day > $daysInMonth) {
            $day = $daysInMonth;
        }

        $day--;

        $date->modify("+ $day days");

        return $date;
    }
}
