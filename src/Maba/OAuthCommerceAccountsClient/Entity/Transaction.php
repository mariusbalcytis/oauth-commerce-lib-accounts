<?php


namespace Maba\OAuthCommerceAccountsClient\Entity;


class Transaction
{
    /**
     * @var int
     */
    protected $beneficiary;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $key;


    public static function create()
    {
        return new static();
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $beneficiary
     *
     * @return $this
     */
    public function setBeneficiary($beneficiary)
    {
        $this->beneficiary = $beneficiary;

        return $this;
    }

    /**
     * @return int
     */
    public function getBeneficiary()
    {
        return $this->beneficiary;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

}
