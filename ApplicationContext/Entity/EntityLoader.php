<?php


namespace Euro\ApplicationContext\Entity;


use Euro\ApplicationContext\XmlApplicationContext;

class EntityLoader
{
    private $entities = array();

    public function loadEntities() {
        try {
            $this->entities = EntityContextProcessor::processContext(XmlApplicationContext::$entitiesPath);

        } catch (InvalidContextException $e) {
            echo $e;
        }
    }

    private function createNewClass($fullClassNameWithNamespace) {
        try {
            $reflectionClass = new \ReflectionClass($fullClassNameWithNamespace);

        } catch (\ReflectionException $e) {
        }
    }
}