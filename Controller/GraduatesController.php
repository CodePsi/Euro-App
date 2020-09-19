<?php


namespace Euro\Controller;


use Euro\Dao\GraduatesDao;
use Euro\DBConnector;
use Euro\Model\Graduates;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;

class GraduatesController
{
    public static function getGraduates($qualificationId) {
        $dao = new GraduatesDao();
        echo json_encode($dao -> where(array("Qualification_ID"), array($qualificationId), array("=")));
    }

    public static function updateGraduate($id, $lastNameUA, $lastNameEN, $firstNameUA, $firstNameEN, $birthday, $serialOfDiploma, $numberOfDiploma, $numberAddition, $prevDocumentUA, $prevDocumentEN, $prevSerialNumberAddition, $durationOfTrainingUA, $durationOfTrainingEN, $trainingStart, $trainingEnd, $actualNumberOfEstimates, $decisionDate, $protocolNum, $qualificationAwardedUA, $qualificationAwardedEN, $issuedBy, $issuedByEN)
    {
        try {
            $dao = new GraduatesDao();
//            echo $dao->get($id)->getId();
            $entry = new Graduates($id, $dao->get($id)->getQualificationId(), $lastNameUA, $lastNameEN, $firstNameUA, $firstNameEN, $birthday, $serialOfDiploma, $numberOfDiploma, $numberAddition, $prevDocumentUA, $prevDocumentEN, $prevSerialNumberAddition, $durationOfTrainingUA, $durationOfTrainingEN, $trainingStart, $trainingEnd, $actualNumberOfEstimates, $decisionDate, $protocolNum, $qualificationAwardedUA, $qualificationAwardedEN, $issuedBy, $issuedByEN);
            $dao -> update($entry);
            http_response_code(200);
        } catch (NotFoundItemException $e) {
            echo 'TEST';
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function createNewGraduate($qualificationId)
    {
        try {
            $dao = new GraduatesDao();
            $entry = new Graduates(-1, $qualificationId, '', '', '', '', date('Y-m-d'), '', '', '', '', '', '', '', '', date('Y-m-d', 0), date('Y-m-d', 0), 0, date('Y-m-d', 0), -1, '', '', '', '');
            echo $dao->save($entry);
        } catch (IncorrectObjectTypeException $e) {
            echo $e;
        }
    }

    public static function deleteGraduate($id)
    {
        try {
            $dao = new GraduatesDao();
            $dao->delete($id);
        } catch (NotFoundItemException $e) {
        }
    }
}