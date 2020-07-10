<?php


namespace Euro\Controller;


use Euro\Dao\DisciplineDao;
use Euro\Dao\EstimatesDao;
use Euro\Dao\GraduatesDao;
use Euro\DBConnector;
use Euro\Model\Discipline;
use Euro\Model\Estimates;
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
            $newEntry = new Discipline($id, $oldEntry -> getQualificationId(), $courseTitleUA, $courseTitleEN, $loans, $hours, $teaching, $differential, $oldEntry -> getSemester(), $oldEntry -> getTeacherId());
            echo $dao -> update($newEntry);
        } catch (NotFoundItemException $e) {
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function createNewDiscipline($qualificationId)
    {
        try {
            $dao = new DisciplineDao();
            $estimateDao = new EstimatesDao();

            $entry = new Discipline(-1, $qualificationId, '', '', '', '', null, '', '', '');
            $disciplineId = $dao->save($entry);
            $graduateDao = new GraduatesDao();
            $graduates = $graduateDao -> where(array('Qualification_ID'), array($qualificationId), array('='));
            foreach ($graduates as $graduate) {
                $estimate = new Estimates(-1, $graduate[1], $disciplineId, -1, 'F', '');
                $estimateDao->save($estimate);
            }
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