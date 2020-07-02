<?php


namespace Euro\Model;


class ContentsAndResults
{
    private $qualificationId;
    private $formStudyUA;
    private $formStudyEN;
    private $programSpecificationUA;
    private $programSpecificationEN;
    private $knowledgeUnderstandingUA;
    private $knowledgeUnderstandingEN;
    private $applicationKnowledgeUnderstandingUA;
    private $applicationKnowledgeUnderstandingEN;
    private $makingJudgmentsUA;
    private $makingJudgmentsEN;

    /**
     * ContentsAndResults constructor.
     * @param $qualificationId
     * @param $formStudyUA
     * @param $formStudyEN
     * @param $programSpecificationUA
     * @param $programSpecificationEN
     * @param $knowledgeUnderstandingUA
     * @param $knowledgeUnderstandingEN
     * @param $applicationKnowledgeUnderstandingUA
     * @param $applicationKnowledgeUnderstandingEN
     * @param $makingJudgmentsUA
     * @param $makingJudgmentsEN
     */
    public function __construct($qualificationId, $formStudyUA, $formStudyEN, $programSpecificationUA, $programSpecificationEN, $knowledgeUnderstandingUA, $knowledgeUnderstandingEN, $applicationKnowledgeUnderstandingUA, $applicationKnowledgeUnderstandingEN, $makingJudgmentsUA, $makingJudgmentsEN)
    {
        $this->qualificationId = $qualificationId;
        $this->formStudyUA = $formStudyUA;
        $this->formStudyEN = $formStudyEN;
        $this->programSpecificationUA = $programSpecificationUA;
        $this->programSpecificationEN = $programSpecificationEN;
        $this->knowledgeUnderstandingUA = $knowledgeUnderstandingUA;
        $this->knowledgeUnderstandingEN = $knowledgeUnderstandingEN;
        $this->applicationKnowledgeUnderstandingUA = $applicationKnowledgeUnderstandingUA;
        $this->applicationKnowledgeUnderstandingEN = $applicationKnowledgeUnderstandingEN;
        $this->makingJudgmentsUA = $makingJudgmentsUA;
        $this->makingJudgmentsEN = $makingJudgmentsEN;
    }

    /**
     * @return mixed
     */
    public function getQualificationId()
    {
        return $this->qualificationId;
    }

    /**
     * @param mixed $qualificationId
     */
    public function setQualificationId($qualificationId): void
    {
        $this->qualificationId = $qualificationId;
    }

    /**
     * @return mixed
     */
    public function getFormStudyUA()
    {
        return $this->formStudyUA;
    }

    /**
     * @param mixed $formStudyUA
     */
    public function setFormStudyUA($formStudyUA): void
    {
        $this->formStudyUA = $formStudyUA;
    }

    /**
     * @return mixed
     */
    public function getFormStudyEN()
    {
        return $this->formStudyEN;
    }

    /**
     * @param mixed $formStudyEN
     */
    public function setFormStudyEN($formStudyEN): void
    {
        $this->formStudyEN = $formStudyEN;
    }

    /**
     * @return mixed
     */
    public function getProgramSpecificationUA()
    {
        return $this->programSpecificationUA;
    }

    /**
     * @param mixed $programSpecificationUA
     */
    public function setProgramSpecificationUA($programSpecificationUA): void
    {
        $this->programSpecificationUA = $programSpecificationUA;
    }

    /**
     * @return mixed
     */
    public function getProgramSpecificationEN()
    {
        return $this->programSpecificationEN;
    }

    /**
     * @param mixed $programSpecificationEN
     */
    public function setProgramSpecificationEN($programSpecificationEN): void
    {
        $this->programSpecificationEN = $programSpecificationEN;
    }

    /**
     * @return mixed
     */
    public function getKnowledgeUnderstandingUA()
    {
        return $this->knowledgeUnderstandingUA;
    }

    /**
     * @param mixed $knowledgeUnderstandingUA
     */
    public function setKnowledgeUnderstandingUA($knowledgeUnderstandingUA): void
    {
        $this->knowledgeUnderstandingUA = $knowledgeUnderstandingUA;
    }

    /**
     * @return mixed
     */
    public function getKnowledgeUnderstandingEN()
    {
        return $this->knowledgeUnderstandingEN;
    }

    /**
     * @param mixed $knowledgeUnderstandingEN
     */
    public function setKnowledgeUnderstandingEN($knowledgeUnderstandingEN): void
    {
        $this->knowledgeUnderstandingEN = $knowledgeUnderstandingEN;
    }

    /**
     * @return mixed
     */
    public function getApplicationKnowledgeUnderstandingUA()
    {
        return $this->applicationKnowledgeUnderstandingUA;
    }

    /**
     * @param mixed $applicationKnowledgeUnderstandingUA
     */
    public function setApplicationKnowledgeUnderstandingUA($applicationKnowledgeUnderstandingUA): void
    {
        $this->applicationKnowledgeUnderstandingUA = $applicationKnowledgeUnderstandingUA;
    }

    /**
     * @return mixed
     */
    public function getApplicationKnowledgeUnderstandingEN()
    {
        return $this->applicationKnowledgeUnderstandingEN;
    }

    /**
     * @param mixed $applicationKnowledgeUnderstandingEN
     */
    public function setApplicationKnowledgeUnderstandingEN($applicationKnowledgeUnderstandingEN): void
    {
        $this->applicationKnowledgeUnderstandingEN = $applicationKnowledgeUnderstandingEN;
    }

    /**
     * @return mixed
     */
    public function getMakingJudgmentsUA()
    {
        return $this->makingJudgmentsUA;
    }

    /**
     * @param mixed $makingJudgmentsUA
     */
    public function setMakingJudgmentsUA($makingJudgmentsUA): void
    {
        $this->makingJudgmentsUA = $makingJudgmentsUA;
    }

    /**
     * @return mixed
     */
    public function getMakingJudgmentsEN()
    {
        return $this->makingJudgmentsEN;
    }

    /**
     * @param mixed $makingJudgmentsEN
     */
    public function setMakingJudgmentsEN($makingJudgmentsEN): void
    {
        $this->makingJudgmentsEN = $makingJudgmentsEN;
    }




}