<?php


namespace Euro\Controller;


use Euro\Printing\ODTDocumentGenerator;

class PrintingController
{
    public static function printOdtDocument($qualificationId) {
        $document = new ODTDocumentGenerator($qualificationId);
        $document -> generateDocument();
    }
}