<?php


namespace Euro\XML;


class XMLContentProcessor
{
    public $content = '';

    public function __construct($content)
    {
        $this->content = htmlspecialchars($content);
    }

    public function replacePattern($pattern, $replace) {
        $this->content = str_replace($pattern, $replace, $this->content);
    }



}