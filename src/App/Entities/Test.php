<?php

namespace App\Entities;

/**
 * Test
 */
class Test
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $loginCount = 0;


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
     * Set name
     *
     * @param string $name
     *
     * @return Test
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Test
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set loginCount
     *
     * @param integer $loginCount
     *
     * @return Test
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;

        return $this;
    }

    /**
     * Get loginCount
     *
     * @return integer
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }
    /**
     * @var \App\Entities\TestRelation
     */
    private $testRelation;


    /**
     * Set testRelation
     *
     * @param \App\Entities\TestRelation $testRelation
     *
     * @return Test
     */
    public function setTestRelation(\App\Entities\TestRelation $testRelation = null)
    {
        $this->testRelation = $testRelation;

        return $this;
    }

    /**
     * Get testRelation
     *
     * @return \App\Entities\TestRelation
     */
    public function getTestRelation()
    {
        return $this->testRelation;
    }
}
