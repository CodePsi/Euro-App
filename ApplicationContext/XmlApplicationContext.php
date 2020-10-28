<?php


namespace Euro\ApplicationContext;


class XmlApplicationContext implements ApplicationContext
{
    private $xmlContext;
    public static $entitiesPath = __DIR__ . "/../resources/entities_context.xml";

    public function __construct(string $xmlContext)
    {
        $this->xmlContext = $xmlContext;
    }

    function getEntity(string $entity)
    {
        // TODO: Implement getEntity() method.
    }
}