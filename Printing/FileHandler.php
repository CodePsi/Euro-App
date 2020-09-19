<?php


namespace Euro\Printing;


use ZipArchive;

class FileHandler
{
    const BACHELOR_DEGREE_XML_FILE = 'content_bachelor_degree.xml';
    const MASTER_DEGREE_XML_FILE = 'content_master_degree.xml';
    private $filename = 'content.xml';
    private $fileType = '';
    private $zipArchive;
    private $fileDescriptor = null;
    public $generalZipArchive = null;
    public $zipFileName = '';

    public function __construct($degree)
    {
        if ($degree === 'Бакалавр') {
            $this->fileType = self::BACHELOR_DEGREE_XML_FILE;
        } else {
            $this->fileType = self::MASTER_DEGREE_XML_FILE;
        }
        $this->generalZipArchive = new ZipArchive();
        $this->zipFileName = realpath('documents') . '/' .  time() . ".zip";
        $this->generalZipArchive -> open($this->zipFileName, ZipArchive::CREATE);

    }

    public function init(): string {
        $this->createCopy();
        $this->openContent();
        return $this->getContent();
    }

    public function createCopy($filename = 'content.xml'): void {
        $this -> filename = realpath('documents') . '/' . $filename;
        copy( realpath('documents/templates/') . '/' . $this->fileType, realpath('documents/') . "/$filename");
    }

    public function openContent(): void {
        $this -> fileDescriptor = fopen($this->filename, 'r');
    }

    public function getContent(): string {
        return fread($this->fileDescriptor, filesize($this->filename));
    }

    public function createODTCopy($copyName) {
        copy( realpath('documents/templates/') . '/WTemplate_PASHA_TEMPLATE_CHANGED_BACHELOR.odt', realpath('documents/') . "/$copyName.odt");
    }

    public function writeContentToFile($content) {
        fclose($this->fileDescriptor);
        $fn = fopen("content.xml", "w");
        fwrite($fn, htmlspecialchars_decode($content), strlen(htmlspecialchars_decode($content)));
        fclose($fn);
    }

    public function setUpODTDocument($filename) {
        $ZIP_ERROR = [
            ZipArchive::ER_EXISTS => 'File already exists.',
            ZipArchive::ER_INCONS => 'Zip archive inconsistent.',
            ZipArchive::ER_INVAL => 'Invalid argument.',
            ZipArchive::ER_MEMORY => 'Malloc failure.',
            ZipArchive::ER_NOENT => 'No such file.',
            ZipArchive::ER_NOZIP => 'Not a zip archive.',
            ZipArchive::ER_OPEN => "Can't open file.",
            ZipArchive::ER_READ => 'Read error.',
            ZipArchive::ER_SEEK => 'Seek error.',
        ];


        $zipArchive = new ZipArchive();
        $code = $zipArchive->open(realpath('documents') . '/' . $filename);
//        var_dump(isset($ZIP_ERROR[$code])? $ZIP_ERROR[$code] : 'Unknown error.');
        $zipArchive->addFile("content.xml");
//        $this->zipArchive->addFile("styles.xml");
        $zipArchive->close();
        $this -> generalZipArchive -> addFile(realpath('documents') . '/' . $filename, $filename);
//        $this->generalZipArchive -> addFile("./test/" . $filename . ".odt", $filename . ".odt");



//        $returnZipArchive -> close();
//        readfile($zipFileName);
    }


}