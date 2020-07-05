<?php


namespace Euro\Controller;


use Euro\Dao\DisciplineDao;
use Euro\Model\Discipline;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;

class DisciplineController
{

    public static function getDisciplines($qualificationId)
    {
        $dao = new DisciplineDao();
        echo json_encode($dao -> where(array("Qualification_ID"), array($qualificationId), array("=")));
    }

    public static function updateDiscipline($id, $courseTitleUA, $courseTitleEN, $loans, $hours, $teaching, $differential)
    {
        try {
            $dao = new DisciplineDao();
            $oldEntry = $dao->get($id);
            $newEntry = new Discipline($id, $oldEntry -> getQualificationId(), $courseTitleUA, $courseTitleEN, $loans, $hours, $teaching, $differential, $oldEntry -> getSemester(), $oldEntry -> getTeachingId());
            $dao -> update($newEntry);
        } catch (NotFoundItemException $e) {
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function createNewDiscipline($qualificationId)
    {
        try {
            $dao = new DisciplineDao();
            $entry = new Discipline(-1, $qualificationId, '', '', '', '', '', '', '', '');
            $dao->save($entry);
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function deleteDiscipline($id)
    {
        $dao = new DisciplineDao();
        try {
            $dao->delete($id);
        } catch (NotFoundItemException $e) {
        }
    }
}