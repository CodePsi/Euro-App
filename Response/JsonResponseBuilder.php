<?php


namespace Euro\Response;


class JsonResponseBuilder implements JsonResponseBuilderInterface
{
    private $json = array();

    public static function createResponse(): JsonResponseBuilderInterface
    {
        return new JsonResponseBuilder();
    }

    public function addNewJsonItem(string $key, string $value): JsonResponseBuilderInterface
    {
        $this -> json[$key] = $value;
        return $this;
    }

    public function addNewJsonItemArray(string $key, array $value): JsonResponseBuilderInterface
    {
        $this -> json[$key] = $value;
        return $this;
    }

    public function build(): string
    {
        return json_encode($this -> json);
    }
}