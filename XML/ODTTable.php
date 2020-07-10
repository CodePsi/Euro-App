<?php


namespace Euro\XML;


class ODTTable implements Table
{
    public $content = '';
    public $position = 0;

    public function __construct($content)
    {
        $this->content = ($content);
        $this->position = strpos($this->content, 'NextRow');

    }

    function addRow($id, $title, $credits, $hours, $marks, $nationalGrade, $ectsGrade): void
    {
//        var_dump($data[0]);
        $rowString = "<table:table-row table:style-name=\"Таблица2.1\"><table:table-cell table:style-name=
        \"Таблица2.A1\" office:value-type=\"string\"><text:p text:style-name=\"P77\">${id}
        </text:p></table:table-cell>
        <table:table-cell table:style-name=\"Таблица2.A1\" office:value-type=\"string\"><text:p text:style-name=\"P77\">
        <text:span text:style-name=\"P72\">${title}</text:span></text:p></table:table-cell>
        <table:table-cell table:style-name=\"Таблица2.A1\" office:value-type=\"string\"><text:p text:style-name=\"P77\">
        <text:span text:style-name=\"P77\">${credits}</text:span></text:p></table:table-cell>
        <table:table-cell table:style-name=\"Таблица2.A1\" office:value-type=\"string\"><text:p text:style-name=\"P77\">${hours}
        </text:p></table:table-cell><table:table-cell table:style-name=\"Таблица2.A1\" office:value-type=\"string\">
        <text:p text:style-name=\"P77\">${marks}</text:p></table:table-cell><table:table-cell table:style-name=\"Таблица2.A1\"
         office:value-type=\"string\"><text:p text:style-name=\"P77\"><text:span text:style-name=\"P77\">${nationalGrade}</text:span>
         </text:p></table:table-cell><table:table-cell table:style-name=\"Таблица2.A1\" office:value-type=\"string\">
         <text:p text:style-name=\"P77\">${ectsGrade}</text:p></table:table-cell></table:table-row>";
//        echo htmlspecialchars($rowString);
//        echo $data[1];
        $this->content = substr($this->content, 0, $this->position) . $rowString . substr($this->content, strpos($this->content, 'NextRow'));
        $this->position = strpos($this->content, 'NextRow');
    }

    function addMergedRow($data): void
    {
        $mergedRow = ("<table:table-row table:style-name=\"Таблица2.1\"><table:table-cell table:style-name=\"Таблица2.A3\" table:number-columns-spanned=\"7\" 
        office:value-type=\"string\"><text:p text:style-name=\"P77\">$data</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/>
        <table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/></table:table-row>");
        $this->content = substr($this->content, 0, $this->position) . $mergedRow . substr($this->content, strpos($this->content, 'NextRow'));
        $this->position = strpos($this->content, 'NextRow');
    }
}