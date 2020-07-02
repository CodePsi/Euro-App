<?php


namespace Euro\Dao;


use Euro\DBConnector;
use Euro\Model\ContentsAndResults;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Utils\Utils;
use mysqli_result;

class ContentsAndResultsDao extends AbstractDao implements Dao, ModelConverter
{
    private $connection;

    public function __construct()
    {
        $this -> connection = new DBConnector();
    }

    /**
     * @param int $id
     * @return object
     * @throws NotFoundItemException
     */
    public function get(int $id): object
    {
        $item = $this -> connection -> execute_query("SELECT * FROM Contents_and_results WHERE Qualification_ID=$id");
        if (!$item || $item -> num_rows === 0) {
            throw new NotFoundItemException("Not found item. Error: " . DBConnector::$mysqli -> error);
        }

        return $this -> convertMysqlResultToModel($item);
    }

    /**
     * @param object $object
     * @return int
     * @throws IncorrectObjectTypeException
     */
    public function save(object $object): int
    {
        if ($object instanceof ContentsAndResults) {
            $formatString = sprintf("INSERT INTO Contents_and_results(Qualification_ID, Form_study_UA, Form_study_EN, 
                                 Program_Specification_UA, Program_Specification_EN, Knowledge_undestanding_UA, Knowledge_undestanding_EN, 
                                 Application_knowledge_understanding_UA, Application_knowledge_understanding_EN, Making_judgments_UA, 
                                 Making_judgments_EN) 
                VALUES (DEFAULT, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $object -> getFormStudyUA(),
                $object -> getFormStudyEN(),
                $object -> getProgramSpecificationUA(),
                $object -> getProgramSpecificationEN(),
                $object -> getKnowledgeUnderstandingUA(),
                $object -> getKnowledgeUnderstandingEN(),
                $object -> getApplicationKnowledgeUnderstandingUA(),
                $object -> getApplicationKnowledgeUnderstandingEN(),
                $object -> getMakingJudgmentsUA(),
                $object -> getMakingJudgmentsEN()
            );
            $this -> connection -> execute_query($formatString);
            return $this -> connection -> getLastInsertedId();
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Graduates");
    }

    /**
     * @param int $id
     * @throws NotFoundItemException
     */
    public function delete(int $id): void
    {
        $stockItem = $this -> connection -> execute_query("DELETE FROM Contents_and_results WHERE Qualification_ID=$id");
        if (!$stockItem || $stockItem -> num_rows === 0) {
            throw new NotFoundItemException("Not found item. Error: " . DBConnector::$mysqli -> error);
        }
    }

    /**
     * @param object $object
     * @return bool
     * @throws IncorrectObjectTypeException
     */
    public function update(object $object): bool
    {
        if ($object instanceof ContentsAndResults) {
            $formatString = sprintf("UPDATE Contents_and_results SET
                     Form_study_UA = '%s',
                     Form_study_EN = '%s',
                     Program_Specification_UA = '%s',
                     Program_Specification_EN = '%s',
                     Knowledge_undestanding_UA = '%s',
                     Knowledge_undestanding_EN = '%s',
                     Application_knowledge_understanding_UA = '%s',
                     Application_knowledge_understanding_EN = '%s',
                     Making_judgments_UA = '%s',
                     Making_judgments_EN = '%s' WHERE Qualification_ID=%d",
                $object -> getFormStudyUA(), $object -> getFormStudyEN(), $object -> getProgramSpecificationUA(), $object -> getProgramSpecificationUA(),
                $object -> getKnowledgeUnderstandingUA(), $object -> getKnowledgeUnderstandingEN(), $object -> getApplicationKnowledgeUnderstandingUA(),
                $object -> getApplicationKnowledgeUnderstandingEN(), $object -> getMakingJudgmentsUA(), $object -> getMakingJudgmentsEN(), $object -> getQualificationId());
            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not ContentsAndResults");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM Contents_and_results");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM Contents_and_results WHERE $stringAndClausesBuilder;");
        return $result -> fetch_all();
    }

    function convertMysqlResultToModel(mysqli_result $mysqliResult): object
    {
        $fetchedRow = $mysqliResult -> fetch_row();
        Utils::cleanArrayFromNull($fetchedRow);
        return new ContentsAndResults($fetchedRow[0],
            $fetchedRow[1],
            $fetchedRow[2],
            $fetchedRow[3],
            $fetchedRow[4],
            $fetchedRow[5],
            $fetchedRow[6],
            $fetchedRow[7],
            $fetchedRow[8],
            $fetchedRow[9],
            $fetchedRow[10]);
    }
}