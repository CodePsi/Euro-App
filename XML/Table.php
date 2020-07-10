<?php


namespace Euro\XML;


interface Table
{
    function addRow($id, $title, $credits, $hours, $marks, $nationalGrade, $ectsGrade): void;
    function addMergedRow($data): void;
}