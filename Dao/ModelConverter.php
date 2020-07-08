<?php


namespace Euro\Dao;


use mysqli_result;

interface ModelConverter
{
    function convertMysqlResultToModel(mysqli_result $mysqliResult): object;
    function convertArrayToModels(array $array): array;
}