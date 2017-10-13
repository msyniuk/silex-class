<?php

namespace App\Entities;

/**
 * Operations
 */
class Operations
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $op_content;

    /**
     * @var \DateTime
     */
    private $op_date;

    /**
     * @var float
     */
    private $op_sum = 0;

    /**
     * @var float
     */
    private $op_sumusd = 0;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set opContent
     *
     * @param string $opContent
     *
     * @return Operations
     */
    public function setOpContent($opContent)
    {
        $this->op_content = $opContent;

        return $this;
    }

    /**
     * Get opContent
     *
     * @return string
     */
    public function getOpContent()
    {
        return $this->op_content;
    }

    /**
     * Set opDate
     *
     * @param \DateTime $opDate
     *
     * @return Operations
     */
    public function setOpDate($opDate)
    {
        $this->op_date = $opDate;

        return $this;
    }

    /**
     * Get opDate
     *
     * @return \DateTime
     */
    public function getOpDate()
    {
        return $this->op_date;
    }

    /**
     * Set opSum
     *
     * @param float $opSum
     *
     * @return Operations
     */
    public function setOpSum($opSum)
    {
        $this->op_sum = $opSum;

        return $this;
    }

    /**
     * Get opSum
     *
     * @return float
     */
    public function getOpSum()
    {
        return $this->op_sum;
    }

    /**
     * Set opSumusd
     *
     * @param float $opSumusd
     *
     * @return Operations
     */
    public function setOpSumusd($opSumusd)
    {
        $this->op_sumusd = $opSumusd;

        return $this;
    }

    /**
     * Get opSumusd
     *
     * @return float
     */
    public function getOpSumusd()
    {
        return $this->op_sumusd;
    }
}

