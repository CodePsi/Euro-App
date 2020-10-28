<?php


namespace Euro\ApplicationContext\Entity;


class EntityContextProcessor
{
    public static function processContext(string $context): array {
        $rootElement = simplexml_load_file($context);
        if ($rootElement -> getName() !== "entities") {
            throw new InvalidContextException('Invalid root element');
        }
        $xmlEntities = $rootElement -> children();
        $objectEntities = [];

        foreach ($xmlEntities -> entity as $entity) {
            $object = new Entity($entity["namespace"], $entity["type"]);
            array_push($objectEntities, $object);
        }
        return $objectEntities;
    }
}