<?php


namespace Euro\Dao;


use Euro\Database\DBConnector;
use Euro\Model\Discipline;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Utils\Utils;
use mysqli_result;

class DisciplineDao extends AbstractDao implements Dao, ModelConverter
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
        $item = $this -> connection -> execute_query("SELECT * FROM Discipline WHERE Discipline_ID=$id");
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
        if ($object instanceof Discipline) {
            $formatString = sprintf("INSERT INTO Discipline(Discipline_ID, Qualification_ID, Course_title_UA, 
                       Course_title_EN, Loans, Hours, Teaching, Differential, Semester) 
                VALUES (DEFAULT, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $object -> getQualificationId(),
                $object -> getCourseTitleUA(),
                $object -> getCourseTitleEN(),
                $object -> getLoans(),
                $object -> getHours(),
                $object -> getTeaching(),
                $object -> getDifferential(),
                $object -> getSemester()
            );
            $this -> connection -> execute_query($formatString);
            return $this -> connection -> getLastInsertedId();
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Discipline");
    }

    /**
     * @param int $id
     * @throws NotFoundItemException
     */
    public function delete(int $id): void
    {
        $stockItem = $this -> connection -> execute_query("DELETE FROM Discipline WHERE Discipline_ID=$id");
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
        if ($object instanceof Discipline) {
            $formatString = sprintf("UPDATE Discipline SET
                     Qualification_ID = %d,
                     Course_title_UA = '%s',
                     Course_title_EN = '%s',
                     Loans = '%s',
                     Hours = '%s',
                     Teaching = '%s',
                     Differential = '%s',
                     Semester = '%s' WHERE Discipline_ID=%d",
                $object -> getQualificationId(), $object -> getCourseTitleUA(), $object -> getCourseTitleEN(), $object -> getLoans(), $object -> getHours(),
                $object -> getTeaching(), $object -> getDifferential(), $object -> getSemester(), $object -> getId());

            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Graduates");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM Discipline");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM Discipline WHERE $stringAndClausesBuilder;");
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
            array_push($resultArray, new Discipline($value[0],
                $value[1],
                $value[2],
                $value[3],
                $value[4],
                $value[5],
                $value[6],
                $value[7],
                $value[8],
                $value[9]));
        }

        return $resultArray;
    }
}