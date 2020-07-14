<?php


namespace Euro\Controller;


use Euro\Dao\QualificationDao;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Model\Qualification;

class QualificationController
{
    public static function getUserQualifications($id) {
        $dao = new QualificationDao();
        echo json_encode($dao -> where(array("User_ID"), array($id), array('=')));
    }

    public static function getQualifications() {
        $dao = new QualificationDao();
        echo json_encode($dao -> getAll());
    }

    public static function getQualification($id) {
        $dao = new QualificationDao();
        try {
            echo $dao->get($id)->toJson();
        } catch (NotFoundItemException $e) {
            echo $e;
        }
    }

    public static function updateQualification($id, $abbreviation, $degree, $qualificationUA, $qualificationEN, $fieldOfStudyUA, $fieldOfStudyEN, $firstSpecialtyUA, $firstSpecialtyEN, $educationalProgramUA, $educationalProgramEN, $secondSpecialtyUA, $secondSpecialtyEN, $specializationUA, $specializationEN)
    {
        try {
            $dao = new QualificationDao();
            $previousInstance = $dao->get($id);
            $qualification = new Qualification($id, $qualificationEN, $qualificationUA, $previousInstance -> getMainFieldStudyEN(), $previousInstance -> getMainFieldStudyEN(), $degree, $previousInstance -> getDate(), $previousInstance -> getUserId(), $abbreviation, $fieldOfStudyUA, $fieldOfStudyEN, $firstSpecialtyUA, $firstSpecialtyEN, $secondSpecialtyUA, $secondSpecialtyEN, $specializationUA, $specializationEN, $educationalProgramUA, $educationalProgramEN);
            $dao -> update($qualification);
        } catch (NotFoundItemException $e) {
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function addNewQualification() {
        try {
            $dao = new QualificationDao();
            /**
             * In this case, we don't need to create any other entries because there's the trigger for creating all necessary entries after insert
            */
            $entity = new Qualification(-1, '', '', '', '','', date("d.m.Y"), $_SESSION['user_id'], '', '', '', '', '', '', '', '', '', '', '');
            $dao->save($entity);
        } catch (IncorrectObjectTypeException $e) {
        }
    }
}