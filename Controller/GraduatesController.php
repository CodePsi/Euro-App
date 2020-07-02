<?php


namespace Euro\Controller;


use Euro\Dao\GraduatesDao;
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
}