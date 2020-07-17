<?php


namespace Euro\Controller;


use Euro\Dao\ContentsAndResultsDao;
use Euro\Model\ContentsAndResults;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;

class ContentsAndResultsController
{

    public static function getContentAndResult($id)
    {
        try {
            $dao = new ContentsAndResultsDao();
            echo $dao->get($id) -> toJson();
        } catch (NotFoundItemException $e) {
        }
    }

    public static function updateContentAndResult($id, $formOfStudyUA, $formOfStudyEN, $programSpecificationUA, $programSpecificationEN, $knowledgeUnderstandingUA, $knowledgeUnderstandingEN, $applicationKnowledgeUnderstandingUA, $applicationKnowledgeUnderstandingEN, $makingJudgmentsUA, $makingJudgmentsEN)
    {
        try {
            $dao = new ContentsAndResultsDao();
            $entry = new ContentsAndResults($id, $formOfStudyUA, $formOfStudyEN, $programSpecificationUA, $programSpecificationEN, $knowledgeUnderstandingUA, $knowledgeUnderstandingEN, $applicationKnowledgeUnderstandingUA, $applicationKnowledgeUnderstandingEN, $makingJudgmentsUA, $makingJudgmentsEN);
            $dao->update($entry);
        } catch (IncorrectObjectTypeException $e) {
        }
    }
}