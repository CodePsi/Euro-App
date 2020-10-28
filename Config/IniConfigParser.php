<?php


namespace Euro\Config;


class IniConfigParser
{
    private $result = array();
    private $filename = '';
    private $section = '';
    private $scannerMode = false;

    public static function newInstance(): IniConfigParser {
        return new IniConfigParser();
    }

    /**
     * @param string $filename
     * @return IniConfigParser
     */
    public function setFilename(string $filename): IniConfigParser
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @param bool $scannerMode
     * @return IniConfigParser
     */
    public function setScannerMode(bool $scannerMode): IniConfigParser
    {
        $this->scannerMode = $scannerMode;
        return $this;
    }

    /**
     * @param string $section
     * @return IniConfigParser
     */
    public function setSection(string $section): IniConfigParser
    {
        $this->section = $section;
        return $this;
    }

    public function parse() {
        if ($this->section === '') {
            return parse_ini_file($this->filename, $this->scannerMode);
        } else {
            return parse_ini_file($this->filename, $this->section, $this->scannerMode);
        }
    }
}