<?php


namespace Euro\Model;


class Qualification
{
    private $id;
    private $qualificationEN;
    private $qualificationUA;
    private $mainFieldStudyUA;
    private $mainFieldStudyEN;
    private $degree;
    private $date;
    private $userId;
    private $abbreviation;
    private $fieldStudyUA;
    private $fieldStudyEN;
    private $firstSpecialtyUA;
    private $firstSpecialtyEN;
    private $secondSpecialtyUA;
    private $secondSpecialtyEN;
    private $specializationUA;
    private $specializationEN;
    private $educationalProgramUA;
    private $educationalProgramEN;

    /**
     * Qualification constructor.
     * @param $id
     * @param $qualificationEN
     * @param $qualificationUA
     * @param $mainFieldStudyUA
     * @param $mainFieldStudyEN
     * @param $degree
     * @param $date
     * @param $userId
     * @param $abbreviation
     * @param $fieldStudyUA
     * @param $fieldStudyEN
     * @param $firstSpecialtyUA
     * @param $firstSpecialtyEN
     * @param $secondSpecialtyUA
     * @param $secondSpecialtyEN
     * @param $specializationUA
     * @param $specializationEN
     * @param $educationalProgramUA
     * @param $educationalProgramEN
     */
    public function __construct($id, $qualificationEN, $qualificationUA, $mainFieldStudyUA, $mainFieldStudyEN, $degree, $date, $userId, $abbreviation, $fieldStudyUA, $fieldStudyEN, $firstSpecialtyUA, $firstSpecialtyEN, $secondSpecialtyUA, $secondSpecialtyEN, $specializationUA, $specializationEN, $educationalProgramUA, $educationalProgramEN)
    {
        $this->id = $id;
        $this->qualificationEN = $qualificationEN;
        $this->qualificationUA = $qualificationUA;
        $this->mainFieldStudyUA = $mainFieldStudyUA;
        $this->mainFieldStudyEN = $mainFieldStudyEN;
        $this->degree = $degree;
        $this->date = $date;
        $this->userId = $userId;
        $this->abbreviation = $abbreviation;
        $this->fieldStudyUA = $fieldStudyUA;
        $this->fieldStudyEN = $fieldStudyEN;
        $this->firstSpecialtyUA = $firstSpecialtyUA;
        $this->firstSpecialtyEN = $firstSpecialtyEN;
        $this->secondSpecialtyUA = $secondSpecialtyUA;
        $this->secondSpecialtyEN = $secondSpecialtyEN;
        $this->specializationUA = $specializationUA;
        $this->specializationEN = $specializationEN;
        $this->educationalProgramUA = $educationalProgramUA;
        $this->educationalProgramEN = $educationalProgramEN;
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
    public function getQualificationEN()
    {
        return $this->qualificationEN;
    }

    /**
     * @param mixed $qualificationEN
     */
    public function setQualificationEN($qualificationEN): void
    {
        $this->qualificationEN = $qualificationEN;
    }

    /**
     * @return mixed
     */
    public function getQualificationUA()
    {
        return $this->qualificationUA;
    }

    /**
     * @param mixed $qualificationUA
     */
    public function setQualificationUA($qualificationUA): void
    {
        $this->qualificationUA = $qualificationUA;
    }

    /**
     * @return mixed
     */
    public function getMainFieldStudyUA()
    {
        return $this->mainFieldStudyUA;
    }

    /**
     * @param mixed $mainFieldStudyUA
     */
    public function setMainFieldStudyUA($mainFieldStudyUA): void
    {
        $this->mainFieldStudyUA = $mainFieldStudyUA;
    }

    /**
     * @return mixed
     */
    public function getMainFieldStudyEN()
    {
        return $this->mainFieldStudyEN;
    }

    /**
     * @param mixed $mainFieldStudyEN
     */
    public function setMainFieldStudyEN($mainFieldStudyEN): void
    {
        $this->mainFieldStudyEN = $mainFieldStudyEN;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree): void
    {
        $this->degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param mixed $abbreviation
     */
    public function setAbbreviation($abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return mixed
     */
    public function getFieldStudyUA()
    {
        return $this->fieldStudyUA;
    }

    /**
     * @param mixed $fieldStudyUA
     */
    public function setFieldStudyUA($fieldStudyUA): void
    {
        $this->fieldStudyUA = $fieldStudyUA;
    }

    /**
     * @return mixed
     */
    public function getFieldStudyEN()
    {
        return $this->fieldStudyEN;
    }

    /**
     * @param mixed $fieldStudyEN
     */
    public function setFieldStudyEN($fieldStudyEN): void
    {
        $this->fieldStudyEN = $fieldStudyEN;
    }

    /**
     * @return mixed
     */
    public function getFirstSpecialtyUA()
    {
        return $this->firstSpecialtyUA;
    }

    /**
     * @param mixed $firstSpecialtyUA
     */
    public function setFirstSpecialtyUA($firstSpecialtyUA): void
    {
        $this->firstSpecialtyUA = $firstSpecialtyUA;
    }

    /**
     * @return mixed
     */
    public function getFirstSpecialtyEN()
    {
        return $this->firstSpecialtyEN;
    }

    /**
     * @param mixed $firstSpecialtyEN
     */
    public function setFirstSpecialtyEN($firstSpecialtyEN): void
    {
        $this->firstSpecialtyEN = $firstSpecialtyEN;
    }

    /**
     * @return mixed
     */
    public function getSecondSpecialtyUA()
    {
        return $this->secondSpecialtyUA;
    }

    /**
     * @param mixed $secondSpecialtyUA
     */
    public function setSecondSpecialtyUA($secondSpecialtyUA): void
    {
        $this->secondSpecialtyUA = $secondSpecialtyUA;
    }

    /**
     * @return mixed
     */
    public function getSecondSpecialtyEN()
    {
        return $this->secondSpecialtyEN;
    }

    /**
     * @param mixed $secondSpecialtyEN
     */
    public function setSecondSpecialtyEN($secondSpecialtyEN): void
    {
        $this->secondSpecialtyEN = $secondSpecialtyEN;
    }

    /**
     * @return mixed
     */
    public function getSpecializationUA()
    {
        return $this->specializationUA;
    }

    /**
     * @param mixed $specializationUA
     */
    public function setSpecializationUA($specializationUA): void
    {
        $this->specializationUA = $specializationUA;
    }

    /**
     * @return mixed
     */
    public function getSpecializationEN()
    {
        return $this->specializationEN;
    }

    /**
     * @param mixed $specializationEN
     */
    public function setSpecializationEN($specializationEN): void
    {
        $this->specializationEN = $specializationEN;
    }

    /**
     * @return mixed
     */
    public function getEducationalProgramUA()
    {
        return $this->educationalProgramUA;
    }

    /**
     * @param mixed $educationalProgramUA
     */
    public function setEducationalProgramUA($educationalProgramUA): void
    {
        $this->educationalProgramUA = $educationalProgramUA;
    }

    /**
     * @return mixed
     */
    public function getEducationalProgramEN()
    {
        return $this->educationalProgramEN;
    }

    /**
     * @param mixed $educationalProgramEN
     */
    public function setEducationalProgramEN($educationalProgramEN): void
    {
        $this->educationalProgramEN = $educationalProgramEN;
    }

    public function toJson(): string {
        return json_encode(array('id' => intval($this -> getId()), 'qualificationEN' => $this -> getQualificationEN(), 'qualificationUA' => $this -> getQualificationUA(), 'mainFieldStudyUA' => $this -> getMainFieldStudyUA(),
            'mainFieldStudyEN' => $this -> getMainFieldStudyEN(), 'degree' => $this -> getDegree(), 'date' => date('Y-m-d', $this -> getDate()), 'userId' => $this -> getUserId(), 'abbreviation' => $this -> getAbbreviation(),
            'fieldStudyUA' => $this -> getFirstSpecialtyUA(), 'fieldStudyEN' => $this -> getFieldStudyEN(), 'firstSpecialtyUA' => $this -> getFirstSpecialtyUA(), 'firstSpecialtyEN' => $this -> getFirstSpecialtyEN(),
            'secondSpecialtyUA' => $this -> getSecondSpecialtyUA(), 'secondSpecialtyEN' => $this -> getSecondSpecialtyEN(), 'specializationUA' => $this -> getSpecializationUA(), 'specializationEN' => $this -> getSpecializationUA(),
            'educationProgramUA' => $this -> getEducationalProgramUA(), 'educationProgramEN' => $this -> getEducationalProgramEN()), JSON_FORCE_OBJECT);
    }



}