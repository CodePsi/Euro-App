<?php


namespace Euro\Model;

class Graduates
{
    private $id;
    private $qualificationId;
    private $lastNameUA;
    private $lastNameEN;
    private $firstNameUA;
    private $firstNameEN;
    private $birthday;
    private $serialOfDiploma;
    private $numberOfDiploma;
    private $numberAddition;
    private $prevDocumentUA;
    private $prevDocumentEN;
    private $prevSerialNumberAddition;
    private $durationOfTrainingUA;
    private $durationOfTrainingEN;
    private $trainingStart;
    private $trainingEnd;
    private $actualNumberOfEstimates;
    private $decisionDate;
    private $protocolNum;
    private $qualificationAwardedUA;
    private $qualificationAwardedEN;
    private $issuedBy;
    private $issuedByEN;

    /**
     * Graduates constructor.
     * @param $id
     * @param $qualificationId
     * @param $lastNameUA
     * @param $lastNameEN
     * @param $firstNameUA
     * @param $firstNameEN
     * @param $birthday
     * @param $serialOfDiploma
     * @param $numberOfDiploma
     * @param $numberAddition
     * @param $prevDocumentUA
     * @param $prevDocumentEN
     * @param $prevSerialNumberAddition
     * @param $durationOfTrainingUA
     * @param $durationOfTrainingEN
     * @param $trainingStart
     * @param $trainingEnd
     * @param $actualNumberOfEstimates
     * @param $decisionDate
     * @param $protocolNum
     * @param $qualificationAwardedUA
     * @param $qualificationAwardedEN
     * @param $issuedBy
     * @param $issuedByEN
     */
    public function __construct($id, $qualificationId, $lastNameUA, $lastNameEN, $firstNameUA, $firstNameEN, $birthday, $serialOfDiploma, $numberOfDiploma, $numberAddition, $prevDocumentUA, $prevDocumentEN, $prevSerialNumberAddition, $durationOfTrainingUA, $durationOfTrainingEN, $trainingStart, $trainingEnd, $actualNumberOfEstimates, $decisionDate, $protocolNum, $qualificationAwardedUA, $qualificationAwardedEN, $issuedBy, $issuedByEN)
    {
        $this->id = $id;
        $this->qualificationId = $qualificationId;
        $this->lastNameUA = $lastNameUA;
        $this->lastNameEN = $lastNameEN;
        $this->firstNameUA = $firstNameUA;
        $this->firstNameEN = $firstNameEN;
        $this->birthday = $birthday;
        $this->serialOfDiploma = $serialOfDiploma;
        $this->numberOfDiploma = $numberOfDiploma;
        $this->numberAddition = $numberAddition;
        $this->prevDocumentUA = $prevDocumentUA;
        $this->prevDocumentEN = $prevDocumentEN;
        $this->prevSerialNumberAddition = $prevSerialNumberAddition;
        $this->durationOfTrainingUA = $durationOfTrainingUA;
        $this->durationOfTrainingEN = $durationOfTrainingEN;
        $this->trainingStart = $trainingStart;
        $this->trainingEnd = $trainingEnd;
        $this->actualNumberOfEstimates = $actualNumberOfEstimates;
        $this->decisionDate = $decisionDate;
        $this->protocolNum = $protocolNum;
        $this->qualificationAwardedUA = $qualificationAwardedUA;
        $this->qualificationAwardedEN = $qualificationAwardedEN;
        $this->issuedBy = $issuedBy;
        $this->issuedByEN = $issuedByEN;
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
    public function getLastNameUA()
    {
        return $this->lastNameUA;
    }

    /**
     * @param mixed $lastNameUA
     */
    public function setLastNameUA($lastNameUA): void
    {
        $this->lastNameUA = $lastNameUA;
    }

    /**
     * @return mixed
     */
    public function getLastNameEN()
    {
        return $this->lastNameEN;
    }

    /**
     * @param mixed $lastNameEN
     */
    public function setLastNameEN($lastNameEN): void
    {
        $this->lastNameEN = $lastNameEN;
    }

    /**
     * @return mixed
     */
    public function getFirstNameUA()
    {
        return $this->firstNameUA;
    }

    /**
     * @param mixed $firstNameUA
     */
    public function setFirstNameUA($firstNameUA): void
    {
        $this->firstNameUA = $firstNameUA;
    }

    /**
     * @return mixed
     */
    public function getFirstNameEN()
    {
        return $this->firstNameEN;
    }

    /**
     * @param mixed $firstNameEN
     */
    public function setFirstNameEN($firstNameEN): void
    {
        $this->firstNameEN = $firstNameEN;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getSerialOfDiploma()
    {
        return $this->serialOfDiploma;
    }

    /**
     * @param mixed $serialOfDiploma
     */
    public function setSerialOfDiploma($serialOfDiploma): void
    {
        $this->serialOfDiploma = $serialOfDiploma;
    }

    /**
     * @return mixed
     */
    public function getNumberOfDiploma()
    {
        return $this->numberOfDiploma;
    }

    /**
     * @param mixed $numberOfDiploma
     */
    public function setNumberOfDiploma($numberOfDiploma): void
    {
        $this->numberOfDiploma = $numberOfDiploma;
    }

    /**
     * @return mixed
     */
    public function getNumberAddition()
    {
        return $this->numberAddition;
    }

    /**
     * @param mixed $numberAddition
     */
    public function setNumberAddition($numberAddition): void
    {
        $this->numberAddition = $numberAddition;
    }

    /**
     * @return mixed
     */
    public function getPrevDocumentUA()
    {
        return $this->prevDocumentUA;
    }

    /**
     * @param mixed $prevDocumentUA
     */
    public function setPrevDocumentUA($prevDocumentUA): void
    {
        $this->prevDocumentUA = $prevDocumentUA;
    }

    /**
     * @return mixed
     */
    public function getPrevDocumentEN()
    {
        return $this->prevDocumentEN;
    }

    /**
     * @param mixed $prevDocumentEN
     */
    public function setPrevDocumentEN($prevDocumentEN): void
    {
        $this->prevDocumentEN = $prevDocumentEN;
    }

    /**
     * @return mixed
     */
    public function getPrevSerialNumberAddition()
    {
        return $this->prevSerialNumberAddition;
    }

    /**
     * @param mixed $prevSerialNumberAddition
     */
    public function setPrevSerialNumberAddition($prevSerialNumberAddition): void
    {
        $this->prevSerialNumberAddition = $prevSerialNumberAddition;
    }

    /**
     * @return mixed
     */
    public function getDurationOfTrainingUA()
    {
        return $this->durationOfTrainingUA;
    }

    /**
     * @param mixed $durationOfTrainingUA
     */
    public function setDurationOfTrainingUA($durationOfTrainingUA): void
    {
        $this->durationOfTrainingUA = $durationOfTrainingUA;
    }

    /**
     * @return mixed
     */
    public function getDurationOfTrainingEN()
    {
        return $this->durationOfTrainingEN;
    }

    /**
     * @param mixed $durationOfTrainingEN
     */
    public function setDurationOfTrainingEN($durationOfTrainingEN): void
    {
        $this->durationOfTrainingEN = $durationOfTrainingEN;
    }

    /**
     * @return mixed
     */
    public function getTrainingStart()
    {
        return $this->trainingStart;
    }

    /**
     * @param mixed $trainingStart
     */
    public function setTrainingStart($trainingStart): void
    {
        $this->trainingStart = $trainingStart;
    }

    /**
     * @return mixed
     */
    public function getTrainingEnd()
    {
        return $this->trainingEnd;
    }

    /**
     * @param mixed $trainingEnd
     */
    public function setTrainingEnd($trainingEnd): void
    {
        $this->trainingEnd = $trainingEnd;
    }

    /**
     * @return mixed
     */
    public function getActualNumberOfEstimates()
    {
        return $this->actualNumberOfEstimates;
    }

    /**
     * @param mixed $actualNumberOfEstimates
     */
    public function setActualNumberOfEstimates($actualNumberOfEstimates): void
    {
        $this->actualNumberOfEstimates = $actualNumberOfEstimates;
    }

    /**
     * @return mixed
     */
    public function getDecisionDate()
    {
        return $this->decisionDate;
    }

    /**
     * @param mixed $decisionDate
     */
    public function setDecisionDate($decisionDate): void
    {
        $this->decisionDate = $decisionDate;
    }

    /**
     * @return mixed
     */
    public function getProtocolNum()
    {
        return $this->protocolNum;
    }

    /**
     * @param mixed $protocolNum
     */
    public function setProtocolNum($protocolNum): void
    {
        $this->protocolNum = $protocolNum;
    }

    /**
     * @return mixed
     */
    public function getQualificationAwardedUA()
    {
        return $this->qualificationAwardedUA;
    }

    /**
     * @param mixed $qualificationAwardedUA
     */
    public function setQualificationAwardedUA($qualificationAwardedUA): void
    {
        $this->qualificationAwardedUA = $qualificationAwardedUA;
    }

    /**
     * @return mixed
     */
    public function getQualificationAwardedEN()
    {
        return $this->qualificationAwardedEN;
    }

    /**
     * @param mixed $qualificationAwardedEN
     */
    public function setQualificationAwardedEN($qualificationAwardedEN): void
    {
        $this->qualificationAwardedEN = $qualificationAwardedEN;
    }

    /**
     * @return mixed
     */
    public function getIssuedBy()
    {
        return $this->issuedBy;
    }

    /**
     * @param $issuedBy
     */
    public function setIssuedBy($issuedBy): void
    {
        $this->issuedBy = $issuedBy;
    }

    /**
     * @return mixed
     */
    public function getIssuedByEN()
    {
        return $this->issuedByEN;
    }

    /**
     * @param mixed issuedByEN
     */
    public function setIssuedByEN($issuedByEN): void
    {
        $this->issuedByEN = $issuedByEN;
    }

    public function toJson(): string
    {
        return json_encode(array('id' => intval($this -> getId()), 'qualificationId' => $this -> getQualificationId(), 'lastNameUA' => $this -> getLastNameUA(), 'lastNameEN' => $this -> getLastNameEN(),
            'firstNameUA' => $this -> getFirstNameUA(), 'firstNameEN' => $this -> getFirstNameEN(), 'birthday' => $this -> getBirthday(), 'serialDiploma' => $this -> getSerialOfDiploma(), 'numberOfDiploma' => $this -> getNumberOfDiploma(),
            'numberAddition' => $this -> getNumberAddition(), 'prevDocumentUA' => $this -> getPrevDocumentUA(), 'prevDocumentEN' => $this -> getPrevDocumentEN(), 'prevSerialNumberAddition' => $this -> getPrevSerialNumberAddition(),
            'durationOfTrainingUA' => $this -> getDurationOfTrainingUA(), 'durationOfTrainingEN' => $this -> getDurationOfTrainingEN(), 'trainingStart' => $this -> getTrainingStart(), 'trainingEnd' => $this -> getTrainingEnd(),
            'actualNumberOfEstimates' => $this -> getActualNumberOfEstimates(), 'decisionDate' => $this -> getDecisionDate(), 'protocolNum' => $this -> getProtocolNum(), 'qualificationAwardedUA' => $this -> getQualificationAwardedUA(), 'qualificationAwardedEN' => $this -> getQualificationAwardedEN(),
            'issuedBy' => $this -> getIssuedBy(), 'issuedByEN' => $this -> getIssuedByEN()), JSON_FORCE_OBJECT);
    }


}