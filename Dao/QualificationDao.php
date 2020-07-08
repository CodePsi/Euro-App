<?php


namespace Euro\Dao;


use Euro\DBConnector;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Model\Qualification;
use Euro\Utils\Utils;
use mysqli_result;

class QualificationDao extends AbstractDao implements Dao, ModelConverter
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
        $item = $this -> connection -> execute_query("SELECT * FROM Qualification WHERE Qualification_ID=$id");
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
        if ($object instanceof Qualification) {
            $formatString = sprintf("INSERT INTO Qualification(Qualification_ID, Qualification_EN, Qualification_UA, 
                          Main_field_study_UA, Main_field_study_EN, Degree, Date, User_ID, abbreviation, FieldStudyUA, 
                          FieldStudyEN, FirstSpecialtyUA, FirstSpecialtyEN, SecondSpecialtyUA, SecondSpecialtyEN, 
                          SpecializationUA, SpecializationEN, EducationalProgramUA, EducationalProgramEN)
                VALUES (DEFAULT, '%s', '%s', '%s', '%s', '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $object -> getQualificationEN(),
                $object -> getQualificationUA(),
                $object -> getMainFieldStudyUA(),
                $object -> getMainFieldStudyEN(),
                $object -> getDegree(),
                $object -> getDate(),
                $object -> getUserId(),
                $object -> getAbbreviation(),
                $object -> getFieldStudyUA(),
                $object -> getFieldStudyEN(),
                $object -> getFirstSpecialtyUA(),
                $object -> getFirstSpecialtyEN(),
                $object -> getSecondSpecialtyUA(),
                $object -> getSecondSpecialtyEN(),
                $object -> getSpecializationUA(),
                $object -> getSpecializationEN(),
                $object -> getEducationalProgramUA(),
                $object -> getEducationalProgramEN()
            );
            $this -> connection -> execute_query($formatString);
            return $this -> connection -> getLastInsertedId();
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Qualification");
    }

    /**
     * @param int $id
     * @throws NotFoundItemException
     */
    public function delete(int $id): void
    {
        $stockItem = $this -> connection -> execute_query("DELETE FROM Qualification WHERE Qualification_ID=$id");
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
        if ($object instanceof Qualification) {
            $formatString = sprintf("UPDATE Qualification SET
                     Qualification_EN = '%s',
                     Qualification_UA = '%s',
                     Main_field_study_UA = '%s',
                     Main_field_study_EN = '%s',
                     Degree = '%s',
                     Date = '%s',
                     User_ID = %d,
                     abbreviation = '%s',
                     FieldStudyUA = '%s',
                     FieldStudyEN = '%s',
                     FirstSpecialtyUA = '%s',
                     FirstSpecialtyEN = '%s',
                     SecondSpecialtyUA = '%s',
                     SecondSpecialtyEN = '%s',
                     SpecializationUA = '%s',
                     SpecializationEN = '%s',
                     EducationalProgramUA = '%s',
                     EducationalProgramEN = '%s' WHERE Qualification_ID=%d",
                $object -> getQualificationEN(), $object -> getQualificationUA(), $object -> getMainFieldStudyUA(), $object -> getMainFieldStudyEN(), $object -> getDegree(),
                $object -> getDate(), $object -> getUserId(), $object -> getAbbreviation(), $object -> getFieldStudyUA(), $object -> getFieldStudyEN(), $object -> getFirstSpecialtyUA(),
                $object -> getFirstSpecialtyEN(), $object -> getSecondSpecialtyUA(), $object -> getSecondSpecialtyEN(), $object -> getSpecializationUA(), $object -> getSpecializationEN(),
                $object -> getEducationalProgramUA(), $object -> getEducationalProgramEN(), $object -> getId());
            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Qualification");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM Qualification");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM Qualification WHERE $stringAndClausesBuilder;");
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
            array_push($resultArray, new Qualification($value[0],
                $value[1],
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
                $value[18]));
        }

        return $resultArray;
    }
}