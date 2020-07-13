<?php


namespace Euro\Model;


class NationalFramework
{
    private $qualificationId;
    private $levelOfQualificationUA;
    private $levelOfQualificationEN;
    private $officialDurationProgrammerUA;
    private $officialDurationProgrammerEN;
    private $accessRequirementsUA;
    private $accessRequirementsEN;
    private $accessFurtherStudyUA;
    private $accessFurtherStudyEN;
    private $professionalStatusUA;
    private $professionalStatusEN;

    /**
     * NationalFramework constructor.
     * @param $qualificationId
     * @param $levelOfQualificationUA
     * @param $levelOfQualificationEN
     * @param $officialDurationProgrammerUA
     * @param $officialDurationProgrammerEN
     * @param $accessRequirementsUA
     * @param $accessRequirementsEN
     * @param $accessFurtherStudyUA
     * @param $accessFurtherStudyEN
     * @param $professionalStatusUA
     * @param $professionalStatusEN
     */
    public function __construct($qualificationId, $levelOfQualificationUA, $levelOfQualificationEN, $officialDurationProgrammerUA, $officialDurationProgrammerEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN)
    {
        $this->qualificationId = $qualificationId;
        $this->levelOfQualificationUA = $levelOfQualificationUA;
        $this->levelOfQualificationEN = $levelOfQualificationEN;
        $this->officialDurationProgrammerUA = $officialDurationProgrammerUA;
        $this->officialDurationProgrammerEN = $officialDurationProgrammerEN;
        $this->accessRequirementsUA = $accessRequirementsUA;
        $this->accessRequirementsEN = $accessRequirementsEN;
        $this->accessFurtherStudyUA = $accessFurtherStudyUA;
        $this->accessFurtherStudyEN = $accessFurtherStudyEN;
        $this->professionalStatusUA = $professionalStatusUA;
        $this->professionalStatusEN = $professionalStatusEN;
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
    public function getLevelOfQualificationUA()
    {
        return $this->levelOfQualificationUA;
    }

    /**
     * @param mixed $levelOfQualificationUA
     */
    public function setLevelQualificationUA($levelOfQualificationUA): void
    {
        $this->levelOfQualificationUA = $levelOfQualificationUA;
    }

    /**
     * @return mixed
     */
    public function getLevelOfQualificationEN()
    {
        return $this->levelOfQualificationEN;
    }

    /**
     * @param $levelOfQualificationEN
     */
    public function setLevelQualificationEN($levelOfQualificationEN): void
    {
        $this->levelOfQualificationEN = $levelOfQualificationEN;
    }

    /**
     * @return mixed
     */
    public function getOfficialDurationProgrammerUA()
    {
        return $this->officialDurationProgrammerUA;
    }

    /**
     * @param mixed $officialDurationProgrammerUA
     */
    public function setOfficialDurationProgrammerUA($officialDurationProgrammerUA): void
    {
        $this->officialDurationProgrammerUA = $officialDurationProgrammerUA;
    }

    /**
     * @return mixed
     */
    public function getOfficialDurationProgrammerEN()
    {
        return $this->officialDurationProgrammerEN;
    }

    /**
     * @param mixed $officialDurationProgrammerEN
     */
    public function setOfficialDurationProgrammerEN($officialDurationProgrammerEN): void
    {
        $this->officialDurationProgrammerEN = $officialDurationProgrammerEN;
    }

    /**
     * @return mixed
     */
    public function getAccessRequirementsUA()
    {
        return $this->accessRequirementsUA;
    }

    /**
     * @param mixed $accessRequirementsUA
     */
    public function setAccessRequirementsUA($accessRequirementsUA): void
    {
        $this->accessRequirementsUA = $accessRequirementsUA;
    }

    /**
     * @return mixed
     */
    public function getAccessRequirementsEN()
    {
        return $this->accessRequirementsEN;
    }

    /**
     * @param mixed $accessRequirementsEN
     */
    public function setAccessRequirementsEN($accessRequirementsEN): void
    {
        $this->accessRequirementsEN = $accessRequirementsEN;
    }

    /**
     * @return mixed
     */
    public function getAccessFurtherStudyUA()
    {
        return $this->accessFurtherStudyUA;
    }

    /**
     * @param mixed $accessFurtherStudyUA
     */
    public function setAccessFurtherStudyUA($accessFurtherStudyUA): void
    {
        $this->accessFurtherStudyUA = $accessFurtherStudyUA;
    }

    /**
     * @return mixed
     */
    public function getAccessFurtherStudyEN()
    {
        return $this->accessFurtherStudyEN;
    }

    /**
     * @param mixed $accessFurtherStudyEN
     */
    public function setAccessFurtherStudyEN($accessFurtherStudyEN): void
    {
        $this->accessFurtherStudyEN = $accessFurtherStudyEN;
    }

    /**
     * @return mixed
     */
    public function getProfessionalStatusUA()
    {
        return $this->professionalStatusUA;
    }

    /**
     * @param mixed $professionalStatusUA
     */
    public function setProfessionalStatusUA($professionalStatusUA): void
    {
        $this->professionalStatusUA = $professionalStatusUA;
    }

    /**
     * @return mixed
     */
    public function getProfessionalStatusEN()
    {
        return $this->professionalStatusEN;
    }

    /**
     * @param mixed $professionalStatusEN
     */
    public function setProfessionalStatusEN($professionalStatusEN): void
    {
        $this->professionalStatusEN = $professionalStatusEN;
    }

    public function toJson(): string {
        return json_encode(array('qualificationId' => intval($this -> getQualificationId()), 'levelOfQualificationUA' => $this -> getLevelOfQualificationUA(), 'levelOfQualificationEN' => $this -> getLevelOfQualificationEN(), 'officialDurationProgrammeUA' => $this -> getOfficialDurationProgrammerUA(),
            'officialDurationProgrammeEN' => $this -> getOfficialDurationProgrammerEN(), 'accessRequirementsUA' => $this -> getAccessRequirementsUA(), 'accessRequirementsEN' => $this -> getAccessRequirementsEN(), 'accessFurtherStudyUA' => $this -> getAccessFurtherStudyUA(), 'accessFurtherStudyEN' => $this -> getAccessFurtherStudyEN(),
            'professionalStatusUA' => $this -> getProfessionalStatusUA(), 'professionalStatusEN' => $this -> getProfessionalStatusEN()), JSON_FORCE_OBJECT);
    }

}