<?php


namespace Euro\Config;


use Euro\Database\DBConnector;

class DatabaseConfiguration implements ObjectConfiguration
{
    private $configData;
    public function __construct()
    {
        $this->configData = IniConfigParser::newInstance()
            -> setFilename(__DIR__ . '\..\database_config.ini')
            -> setSection('connection_config')
            -> parse();
    }

    function initializeObject(): object
    {
//        $connector = new DBConnector();
        return new DBConnector();
    }
    
    /**
     * @return array|false
     */
    public function getConfigData()
    {
        return $this->configData;
    }
}