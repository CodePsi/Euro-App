<?php


namespace Euro\Dao;


use Euro\DBConnector;
use Euro\Model\Estimates;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Utils\Utils;
use mysqli_result;

class EstimatesDao extends AbstractDao implements Dao, ModelConverter
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
        $item = $this -> connection -> execute_query("SELECT * FROM Estimates WHERE Graduat_ID=$id");
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
        if ($object instanceof Estimates) {
            $formatString = sprintf("INSERT INTO Estimates(Graduat_ID, Disciptine_ID, Estimat_NUM, Estimat_CHAR, Estimat_UA, Estimat_ID) 
                VALUES (%d, %d, '%s', '%s', '%s', DEFAULT);",
                $object -> getGraduateId(),
                $object -> getDisciplineId(),
                $object -> getEstimateNum(),
                $object -> getEstimateChar(),
                $object -> getEstimateUa()
            );
            $this -> connection -> execute_query($formatString);
            return $this -> connection -> getLastInsertedId();
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Estimates");
    }

    /**
     * @param int $id
     * @throws NotFoundItemException
     */
    public function delete(int $id): void
    {
        $stockItem = $this -> connection -> execute_query("DELETE FROM Estimates WHERE Graduat_ID=$id");
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
        if ($object instanceof Estimates) {
            $formatString = sprintf("UPDATE Estimates SET
                     Graduat_ID = %d,
                     Disciptine_ID = %d,
                     Estimat_NUM = '%s',
                     Estimat_CHAR = '%s',
                     Estimat_UA = '%s' WHERE Estimat_ID=%d",
                $object -> getGraduateId(), $object -> getDisciplineId(), $object -> getEstimateNum(), $object -> getEstimateChar(), $object -> getEstimateUa(), $object -> getId());
            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not Graduates");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM Estimates");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM Estimates WHERE $stringAndClausesBuilder;");
        return $result -> fetch_all();
    }

    function convertMysqlResultToModel(mysqli_result $mysqliResult): object
    {
        $fetchedRow = $mysqliResult -> fetch_row();
        Utils::cleanArrayFromNull($fetchedRow);
        return new Estimates($fetchedRow[0],
            $fetchedRow[1],
            $fetchedRow[2],
            $fetchedRow[3],
            $fetchedRow[4],
            $fetchedRow[5]);
    }
}