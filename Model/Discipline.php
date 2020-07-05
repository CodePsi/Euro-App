<?php


namespace Euro\Model;


class Discipline
{
    private $id;
    private $qualificationId;
    private $courseTitleUA;
    private $courseTitleEN;
    private $loans;
    private $hours;
    private $teaching;
    private $differential;
    private $semester;
    private $teacherId;

    /**
     * Discipline constructor.
     * @param $id
     * @param $qualificationId
     * @param $courseTitleUA
     * @param $courseTitleEN
     * @param $loans
     * @param $hours
     * @param $teaching
     * @param $differential
     * @param $semester
     * @param $teacherId
     */
    public function __construct($id, $qualificationId, $courseTitleUA, $courseTitleEN, $loans, $hours, $teaching, $differential, $semester, $teacherId)
    {
        $this->id = $id;
        $this->qualificationId = $qualificationId;
        $this->courseTitleUA = $courseTitleUA;
        $this->courseTitleEN = $courseTitleEN;
        $this->loans = $loans;
        $this->hours = $hours;
        $this->teaching = $teaching;
        $this->differential = $differential;
        $this->semester = $semester;
        $this->teacherId = $teacherId;
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
    public function getCourseTitleUA()
    {
        return $this->courseTitleUA;
    }

    /**
     * @param mixed $courseTitleUA
     */
    public function setCourseTitleUA($courseTitleUA): void
    {
        $this->courseTitleUA = $courseTitleUA;
    }

    /**
     * @return mixed
     */
    public function getCourseTitleEN()
    {
        return $this->courseTitleEN;
    }

    /**
     * @param mixed $courseTitleEN
     */
    public function setCourseTitleEN($courseTitleEN): void
    {
        $this->courseTitleEN = $courseTitleEN;
    }

    /**
     * @return mixed
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * @param mixed $loans
     */
    public function setLoans($loans): void
    {
        $this->loans = $loans;
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours): void
    {
        $this->hours = $hours;
    }

    /**
     * @return mixed
     */
    public function getTeaching()
    {
        return $this->teaching;
    }

    /**
     * @param mixed $teaching
     */
    public function setTeaching($teaching): void
    {
        $this->teaching = $teaching;
    }

    /**
     * @return mixed
     */
    public function getDifferential()
    {
        return $this->differential;
    }

    /**
     * @param mixed $differential
     */
    public function setDifferential($differential): void
    {
        $this->differential = $differential;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester): void
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param mixed $teacherId
     */
    public function setTeacherId($teacherId): void
    {
        $this->teacherId = $teacherId;
    }

    public function toJson(): string
    {
        return json_encode(array('id' => intval($this -> getId()), 'qualificationId' => $this -> getQualificationId(), 'courseTitleUA' => $this -> getCourseTitleUA(), 'courseTitleEN' => $this -> getCourseTitleEN(),
            'loans' => $this -> getLoans(), 'hours' => $this -> getHours(), 'teaching' => $this -> getTeaching(), 'differential' => $this -> getDifferential(), 'semester' => $this -> getSemester(),
            'teacherId' => $this -> getTeacherId()), JSON_FORCE_OBJECT);
    }


}