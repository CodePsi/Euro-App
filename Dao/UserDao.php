<?php


namespace Euro\Dao;


use Euro\DBConnector;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;
use Euro\Model\User;
use Euro\Utils\Utils;
use mysqli_result;

class UserDao extends AbstractDao implements Dao, ModelConverter
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
        $item = $this -> connection -> execute_query("SELECT * FROM User WHERE User_ID=$id");
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
        if ($object instanceof User) {
            $formatString = sprintf("INSERT INTO User(User_ID, Name, pass, `e-mail`, phone_number, is_admin)
                VALUES (DEFAULT, '%s', '%s', '%s', '%s', %d);",
                $object -> getName(),
                $object -> getPassword(),
                $object -> getEmail(),
                $object -> getPhoneNumber(),
                $object -> getIsAdmin()
            );
            $this -> connection -> execute_query($formatString);
            return $this -> connection -> getLastInsertedId();
        }

        throw new IncorrectObjectTypeException("Passed object's type is not User");
    }

    /**
     * @param int $id
     * @throws NotFoundItemException
     */
    public function delete(int $id): void
    {
        $stockItem = $this -> connection -> execute_query("DELETE FROM User WHERE User_ID=$id");
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
        if ($object instanceof User) {
            $formatString = sprintf("UPDATE User SET
                     Name = '%s',
                     pass = '%s',
                     `e-mail` = '%s',
                     phone_number = '%s',
                     is_admin = '%s' WHERE User_ID=%d",
                $object -> getName(), $object -> getPassword(), $object -> getEmail(), $object -> getPhoneNumber(), $object -> getIsAdmin(), $object -> getId());
            return $this -> connection -> execute_query($formatString);
        }

        throw new IncorrectObjectTypeException("Passed object's type is not User");
    }

    public function getAll(): array
    {
        $result = $this -> connection -> execute_query("SELECT * FROM User");
        return $result -> fetch_all();
    }

    public function where(array $fields, array $values, array $operators): array
    {
        $stringAndClausesBuilder = $this->buildAndClauses($fields, $values, $operators);
        $result = $this -> connection -> execute_query("SELECT * FROM User WHERE $stringAndClausesBuilder;");
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
            array_push($resultArray, new User($value[0],
                $value[1],
                $value[2],
                $value[3],
                $value[4],
                $value[5]));
        }

        return $resultArray;
    }
}