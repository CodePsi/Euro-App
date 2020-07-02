<?php


namespace Euro\Model;


class Estimates
{
    private $id;
    private $graduateId;
    private $disciplineId;
    private $estimateNum;
    private $estimateChar;
    private $estimateUa;

    /**
     * Estimates constructor.
     * @param $id
     * @param $graduateId
     * @param $disciplineId
     * @param $estimateNum
     * @param $estimateChar
     * @param $estimateUa
     */
    public function __construct($id, $graduateId, $disciplineId, $estimateNum, $estimateChar, $estimateUa)
    {
        $this->id = $id;
        $this->graduateId = $graduateId;
        $this->disciplineId = $disciplineId;
        $this->estimateNum = $estimateNum;
        $this->estimateChar = $estimateChar;
        $this->estimateUa = $estimateUa;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGraduateId()
    {
        return $this->graduateId;
    }

    /**
     * @param mixed $graduateId
     */
    public function setGraduateId($graduateId): void
    {
        $this->graduateId = $graduateId;
    }

    /**
     * @return mixed
     */
    public function getDisciplineId()
    {
        return $this->disciplineId;
    }

    /**
     * @param mixed $disciplineId
     */
    public function setDisciplineId($disciplineId): void
    {
        $this->disciplineId = $disciplineId;
    }

    /**
     * @return mixed
     */
    public function getEstimateNum()
    {
        return $this->estimateNum;
    }

    /**
     * @param mixed $estimateNum
     */
    public function setEstimateNum($estimateNum): void
    {
        $this->estimateNum = $estimateNum;
    }

    /**
     * @return mixed
     */
    public function getEstimateChar()
    {
        return $this->estimateChar;
    }

    /**
     * @param mixed $estimateChar
     */
    public function setEstimateChar($estimateChar): void
    {
        $this->estimateChar = $estimateChar;
    }

    /**
     * @return mixed
     */
    public function getEstimateUa()
    {
        return $this->estimateUa;
    }

    /**
     * @param mixed $estimateUa
     */
    public function setEstimateUa($estimateUa): void
    {
        $this->estimateUa = $estimateUa;
    }




}