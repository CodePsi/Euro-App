<?php


namespace Euro\Controller;


use Euro\Dao\ContentsAndResultsDao;
use Euro\Dao\NationalFrameworkDao;
use Euro\Dao\QualificationDao;
use Euro\Database\DBConnector;
use Euro\Model\ContentsAndResults;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NationalFramework;
use Euro\Model\NotFoundItemException;
use Euro\Model\Qualification;
use Euro\Response\Response;
use function foo\func;

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


    public static function updateQualification($id, $abbreviation, $degree, $qualificationUA, $qualificationEN, $fieldStudyUA, $fieldStudyEN, $firstSpecialtyUA, $firstSpecialtyEN, $educationalProgramUA, $educationalProgramEN, $secondSpecialtyUA, $secondSpecialtyEN, $specializationUA, $specializationEN)
    {
        try {
            $dao = new QualificationDao();
            $previousInstance = $dao->get($id);
            $qualification = new Qualification($id, $qualificationEN, $qualificationUA, $previousInstance -> getMainFieldStudyEN(), $previousInstance -> getMainFieldStudyEN(), $degree, $previousInstance -> getDate(), $previousInstance -> getUserId(), $abbreviation, $fieldStudyUA, $fieldStudyEN, $firstSpecialtyUA, $firstSpecialtyEN, $secondSpecialtyUA, $secondSpecialtyEN, $specializationUA, $specializationEN, $educationalProgramUA, $educationalProgramEN);
            var_dump($qualification);
            $dao -> update($qualification);
        } catch (NotFoundItemException $e) {
            echo $e;
        } catch (IncorrectObjectTypeException $e) {
            echo $e;
        }
    }

    public static function addNewQualification() {
        try {
            $dao = new QualificationDao();
            /**
             * In this case, we don't need to create any other entries because there's the trigger for creating all necessary entries after insert
            */
            $nationalFrameworkDao = new NationalFrameworkDao();
            $contentsAndResultsDao = new ContentsAndResultsDao();


            $entity = new Qualification(-1, '', '', '', '','', date("d.m.Y"), $_SESSION['user_id'], '', '', '', '', '', '', '', '', '', '', '');
            $qualificationId = $dao->save($entity);
            echo $qualificationId;
            $nationalFrameworkEntity = new NationalFramework($qualificationId, '', '', '', '', '', '','' ,'', '', '');
            $contentsAndResultsEntity = new ContentsAndResults($qualificationId, '', '','', '', '', '', '', '', '','');

            $nationalFrameworkDao -> save($nationalFrameworkEntity);

            $contentsAndResultsDao -> save($contentsAndResultsEntity);
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function deleteQualification($id)
    {
        try {
            $dao = new QualificationDao();
            self::deleteForSaveEntry($id);
            $dao->delete($id);
        } catch (NotFoundItemException $e) {
            Response::text($e);
        }
    }

    /**
     * Delete entry from the For_save table.
     *
     * Explanation. The For_save table is quite dangerous and useless, it has a lot of internal links, but
     * there's no any use in code. I did not create it, I only did a wrapper for all of it, so, maybe,
     * I will take care of it in the future. So, as I said above, It is useless, therefore my decision was
     * not to create an individual Dao class for this purpose. Its function execute the direct query to database
     * and delete an entry by the qualification id.
     *
     * @param $qualificationId
     */
    private static function deleteForSaveEntry($qualificationId)
    {
        $connector = new DBConnector();
        $connector -> execute_query("DELETE FROM For_save WHERE Qualification_ID=$qualificationId");
    }
}