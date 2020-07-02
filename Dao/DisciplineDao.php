<?php


namespace Euro\Dao;


use Euro\DBConnector;
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
                       Course_title_EN, Loans, Hours, Teaching, Differential, Semester, Teacher_ID) 
                VALUES (DEFAULT, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $object -> getQualificationId(),
                $object -> getCourseTitleUA(),
                $object -> getCourseTitleEN(),
                $object -> getLoans(),
                $object -> getHours(),
                $object -> getTeaching(),
                $object -> getDifferential(),
                $object -> getSemester(),
                $object -> getTeacherId()
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
                     Semester = '%s',
                     Teacher_ID = '%s' WHERE Discipline_ID=%d",
                $object -> getQualificationId(), $object -> getCourseTitleUA(), $object -> getCourseTitleEN(), $object -> getLoans(), $object -> getHours(),
                $object -> getTeaching(), $object -> getDifferential(), $object -> getSemester(), $object -> getTeacherId(),
                $object -> getId());
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
        $fetchedRow = $mysqliResult -> fetch_row();
        Utils::cleanArrayFromNull($fetchedRow);
        return new Discipline($fetchedRow[0],
            $fetchedRow[1],
            $fetchedRow[2],
            $fetchedRow[3],
            $fetchedRow[4],
            $fetchedRow[5],
            $fetchedRow[6],
            $fetchedRow[7],
            $fetchedRow[8],
            $fetchedRow[9]);
    }
}