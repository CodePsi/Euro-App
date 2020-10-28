<?php


namespace Euro\Dao;


use Euro\Database\DBConnector;
use Euro\Model\Graduates;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Utils\Utils;
use mysqli_result;

class GraduatesDao extends AbstractDao implements Dao, ModelConverter
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
        $item = $this -> connection -> execute_query("SELECT * FROM graduates WHERE Graduat_ID=$id");
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
        if ($object instanceof Graduates) {
            $formatString = sprintf("INSERT INTO graduates(Qualification_ID, Graduat_ID, Lastname_UA, Lastname_EN, Firstname_UA, 
                      Firstname_EN, birthday, SerialDiploma, NumberDiploma, NumberAddition, PrevDocument_UA, PrevDocument_EN, 
                      prevSerialNumberAddition, DurationOfTraining_UA, DurationOfTraining_EN, TrainingStar, TrainingEnd,
                      Actual_number_estimates, DecisionDate, ProtNum, QualificationAwardedUA, QualificationAwardedEN, IssuedBy, IssuedBy_EN) 
                VALUES (%d, DEFAULT, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $object -> getQualificationId(),
                $object -> getLastNameUA(),
                $object -> getLastNameEN(),
                $object -> getFirstNameUA(),
                $object -> getFirstNameEN(),
                $object -> getBirthday(),
                $object -> getSerialOfDiploma(),
                $object -> getNumberOfDiploma(),
                $object -> getNumberAddition(),
                $object -> getPrevDocumentUA(),
                $object -> getPrevDocumentEN(),
                $object -> getPrevSerialNumberAddition(),
                $object -> getDurationOfTrainingUA(),
                $object -> getDurationOfTrainingEN(),
                $object -> getTrainingStart(),
                $object -> getTrainingEnd(),
                $object -> getActualNumberOfEstimates(),
                $object -> getDecisionDate(),
                $object -> getProtocolNum(),
                $object -> getQualificationAwardedUA(),
                $object -> getQualificationAwardedEN(),
                $object -> getIssuedBy(),
                $object -> getIssuedByEN()
            );
            $this -> connection -> execute_query($formatString);
            echo DBConnector::getStatus();
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
        $stockItem = $this -> connection -> execute_query("DELETE FROM graduates WHERE Graduat_ID=$id");
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
        if ($object instanceof Graduates) {
            $formatString = sprintf("UPDATE graduates SET
                     Qualification_ID = %d,
                     Lastname_UA = '%s',
                     Lastname_EN = '%s',
                     Firstname_UA = '%s',
                     Firstname_EN = '%s',
                     birthday = '%s',
                     SerialDiploma = '%s',
                     NumberDiploma = '%s',
                     NumberAddition = '%s',
                     PrevDocument_UA = '%s',
                     PrevDocument_EN = '%s',
                     prevSerialNumberAddition = '%s',
                     DurationOfTraining_UA = '%s',
                     DurationOfTraining_EN = '%s',
                     TrainingStar = '%s',
                     TrainingEnd = '%s',
                     Actual_number_estimates = '%s',
                     DecisionDate = '%s',
                     ProtNum = '%s',
                     QualificationAwardedUA = '%s',
                     QualificationAwardedEN = '%s',
                     IssuedBy = '%s', 
                     IssuedBy_EN = '%s' WHERE Graduat_ID=%d",
                $object -> getQualificationId(), $object -> getLastNameUA(), $object -> getLastNameEN(), $object -> getFirstNameUA(), $object -> getFirstNameEN(),
                $object -> getBirthday(), $object -> getSerialOfDiploma(), $object -> getNumberOfDiploma(), $object -> getNumberAddition(),
                $object -> getPrevDocumentUA(), $object -> getPrevDocumentEN(), $object -> getPrevSerialNumberAddition(), $object -> getDurationOfTrainingUA(),
                $object -> getDurationOfTrainingEN(), $object -> getTrainingStart(), $object -> getTrainingEnd(), 0,
                $object -> getDecisionDate(), $object -> getProtocolNum(), $object -> getQualificationAwardedUA(), $object -> getQualificationAwardedEN(), $object -> getIssuedBy(), $object -> getIssuedByEN(), $object -> getId());
            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Graduates");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM graduates");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM graduates WHERE $stringAndClausesBuilder;");
        return $result -> fetch_all();
    }

    function convertMysqlResultToModel(mysqli_result $mysqliResult): object
    {
        $fetchedRow = array($mysqliResult -> fetch_row());
        return $this -> convertArrayToModels($fetchedRow)[0];
    }

    function convertArrayToModels(array $array): array
    {
        $resultArray = array();
        foreach ($array as $value) {
            Utils::cleanArrayFromNull($value);
            array_push($resultArray, new Graduates($value[1],
                $value[0],
                $value[2],
                $value[3],
                $value[4],
                $value[5],
                $value[6],
                $value[7],
                $value[8],
                $value[9],
                $value[10],
                $value[11],
                $value[12],
                $value[13],
                $value[14],
                $value[15],
                $value[16],
                $value[17],
                $value[18],
                $value[19],
                $value[20],
                $value[21],
                $value[22],
                $value[23]));
        }

        return $resultArray;
    }
}