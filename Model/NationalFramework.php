<?php


namespace Euro\Model;


class NationalFramework
{
    private $qualificationId;
    private $levelQualificationUA;
    private $levelQualificationEN;
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
     * @param $levelQualificationUA
     * @param $levelQualificationEN
     * @param $officialDurationProgrammerUA
     * @param $officialDurationProgrammerEN
     * @param $accessRequirementsUA
     * @param $accessRequirementsEN
     * @param $accessFurtherStudyUA
     * @param $accessFurtherStudyEN
     * @param $professionalStatusUA
     * @param $professionalStatusEN
     */
    public function __construct($qualificationId, $levelQualificationUA, $levelQualificationEN, $officialDurationProgrammerUA, $officialDurationProgrammerEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN)
    {
        $this->qualificationId = $qualificationId;
        $this->levelQualificationUA = $levelQualificationUA;
        $this->levelQualificationEN = $levelQualificationEN;
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
    public function getLevelQualificationUA()
    {
        return $this->levelQualificationUA;
    }

    /**
     * @param mixed $levelQualificationUA
     */
    public function setLevelQualificationUA($levelQualificationUA): void
    {
        $this->levelQualificationUA = $levelQualificationUA;
    }

    /**
     * @return mixed
     */
    public function getLevelQualificationEN()
    {
        return $this->levelQualificationEN;
    }

    /**
     * @param mixed $levelQualificationEN
     */
    public function setLevelQualificationEN($levelQualificationEN): void
    {
        $this->levelQualificationEN = $levelQualificationEN;
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



}