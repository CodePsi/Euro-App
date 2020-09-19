<?php


namespace Euro\Response;


interface JsonResponseBuilderInterface
{
    function addNewJsonItem(string $key, string $value): JsonResponseBuilderInterface;
    function addNewJsonItemArray(string $key, array $value): JsonResponseBuilderInterface;
    function build(): string;
}