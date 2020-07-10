<?php


namespace Euro\Printing;


use Euro\Dao\ContentsAndResultsDao;
use Euro\Dao\DisciplineDao;
use Euro\Dao\EstimatesDao;
use Euro\Dao\GraduatesDao;
use Euro\Dao\NationalFrameworkDao;
use Euro\Dao\QualificationDao;
use Euro\Model\ContentsAndResults;
use Euro\Model\Discipline;
use Euro\Model\Graduates;
use Euro\Model\NationalFramework;
use Euro\Model\NotFoundItemException;
use Euro\Model\Qualification;
use Euro\XML\ODTTable;
use Euro\XML\Table;
use Euro\XML\XMLContentProcessor;

class ODTDocumentGenerator implements Document
{
    public $qualificationId;
    private $allCredits = 0;
    private $allHours = 0;

    public function __construct($qualificationId)
    {
        $this -> qualificationId = $qualificationId;
    }

    function generateDocument()
    {
        $graduateDao = new GraduatesDao();
        $qualificationDao = new QualificationDao();
        $contentAndResultsDao = new ContentsAndResultsDao();
        $nationalFrameworkDao = new NationalFrameworkDao();
        $estimateDao = new EstimatesDao();
        $disciplineDao = new DisciplineDao();

        $graduates = $graduateDao -> where(array('Qualification_ID'), array($this->qualificationId), array('='));
        $qualifications = $qualificationDao -> where(array('Qualification_ID'), array($this->qualificationId), array('='));
        $contentAndResults = $contentAndResultsDao -> where(array('Qualification_ID'), array($this->qualificationId), array('='));
        $nationalFramework = $nationalFrameworkDao -> where(array('Qualification_ID'), array($this->qualificationId), array('='));

        $qualificationsModel = $qualificationDao -> convertArrayToModels($qualifications)[0];
        $graduatesModels = $graduateDao -> convertArrayToModels($graduates);
        $contentAndResultsModel = $contentAndResultsDao -> convertArrayToModels($contentAndResults)[0];
        $nationalFrameworkModel = $nationalFrameworkDao -> convertArrayToModels($nationalFramework)[0];

        $degree = $qualificationsModel -> getDegree();

        $prefix = "PASHA_";


        $fileHandler = new FileHandler($degree);

//        var_dump($graduatesModels);
//        var_dump($graduatesModels);
        for ($i = 0; $i < count($graduatesModels); $i++) {
            $this->allHours = 0;
            $this->allCredits = 0;
            $content = $fileHandler -> init();
            $processor = new XMLContentProcessor($content);
            $odt = "test" . $i . time();
//            $qualificationsModel = new Qualification();
//            $contentAndResultsModel = new ContentsAndResults();
//            $nationalFrameworkModel = new NationalFramework();
            $processor -> replacePattern('SerialDiploma', $graduatesModels[$i] -> getSerialOfDiploma());
            $processor -> replacePattern('numberDiploma', $graduatesModels[$i] -> getNumberOfDiploma());
            $processor -> replacePattern('numberAddition', $graduatesModels[$i] -> getNumberAddition());
            $processor -> replacePattern($prefix . 'lastname_UA', $graduatesModels[$i] -> getLastNameUA());
            $processor -> replacePattern($prefix . 'lastname_EN', $graduatesModels[$i] -> getLastNameEN());
            $processor -> replacePattern($prefix . 'firstname_UA', $graduatesModels[$i] -> getFirstNameUA());
            $processor -> replacePattern($prefix . 'firstname_EN', $graduatesModels[$i] -> getFirstNameEN());
            $processor -> replacePattern($prefix . 'birthday', date("d.m.Y", strtotime($graduatesModels[$i] -> getBirthday())));
            $processor -> replacePattern('DegreeUA', $degree);
            $processor -> replacePattern('DegreeEN', $degree === 'Бакалавр' ? 'Bachelor' : 'Master');
            $processor -> replacePattern($prefix . 'SpecialtyUA', $qualificationsModel -> getFirstSpecialtyUA());
            $processor -> replacePattern($prefix . 'SpecialtyEN', $qualificationsModel -> getFirstSpecialtyEN());
            if (!empty($qualificationsModel -> getSpecializationUA()) && !empty($qualificationsModel -> getSpecializationEN())) {
                $processor -> replacePattern($prefix . 'SpecializationUA', 'Спеціалізація: ' . $qualificationsModel -> getSpecializationUA());
                $processor -> replacePattern($prefix . 'SpecializationEN', 'Specialization: ' . $qualificationsModel -> getSpecializationEN());
            } else if (!empty($qualificationsModel -> getSecondSpecialtyUA()) && !empty($qualificationsModel -> getSecondSpecialtyEN())) {
                $processor -> replacePattern($prefix . 'SpecializationUA', 'Додаткова спеціальність: ' . $qualificationsModel -> getSecondSpecialtyUA());
                $processor -> replacePattern($prefix . 'SpecializationEN', 'Additional specialty: ' . $qualificationsModel -> getSecondSpecialtyEN());
            }
            $processor -> replacePattern($prefix . 'EducationalProgramUA', $qualificationsModel -> getEducationalProgramUA());
            $processor -> replacePattern($prefix . 'EducationalProgramEN', $qualificationsModel -> getEducationalProgramUA());
            $processor -> replacePattern($prefix . 'qualification_UA', $qualificationsModel -> getQualificationUA());
            $processor -> replacePattern($prefix . 'qualification_EN', $qualificationsModel -> getQualificationEN());
            $processor -> replacePattern($prefix . 'FieldStudyUA', $qualificationsModel -> getMainFieldStudyUA());
            $processor -> replacePattern($prefix . 'FieldStudyEN', $qualificationsModel -> getMainFieldStudyEN());
            $processor -> replacePattern($prefix . 'durationProgram_UA', $graduatesModels[$i] -> getDurationOfTrainingUA());
            $processor -> replacePattern($prefix . 'durationProgram_EN', $graduatesModels[$i] -> getDurationOfTrainingEN());
            $processor -> replacePattern($prefix . 'accessRequiments_UA', $nationalFrameworkModel -> getAccessRequirementsUA());
            $processor -> replacePattern($prefix . 'accessRequiments_EN', $nationalFrameworkModel -> getAccessRequirementsEN());
            $processor -> replacePattern($prefix . 'modeStudy', $contentAndResultsModel -> getFormStudyUA() . ' / ' . $contentAndResultsModel -> getFormStudyEN());
            $processor -> replacePattern($prefix . 'programSpecification_UA', $contentAndResultsModel -> getProgramSpecificationUA());
            $processor -> replacePattern($prefix . 'programSpecification_EN', $contentAndResultsModel -> getProgramSpecificationEN());
            $processor -> replacePattern($prefix . 'knowledgeUnderstanding_UA', $contentAndResultsModel -> getKnowledgeUnderstandingUA());
            $processor -> replacePattern($prefix . 'applyingKnowledge_UA', $contentAndResultsModel -> getApplicationKnowledgeUnderstandingUA());
            $processor -> replacePattern($prefix . 'MakingJudgments_UA', $contentAndResultsModel -> getMakingJudgmentsUA());
            $processor -> replacePattern($prefix . 'knowledgeUnderstanding_EN', $contentAndResultsModel -> getKnowledgeUnderstandingEN());
            $processor -> replacePattern($prefix . 'applyingKnowledge_EN', $contentAndResultsModel -> getApplicationKnowledgeUnderstandingEN());
            $processor -> replacePattern($prefix . 'MakingJudgments_EN', $contentAndResultsModel -> getMakingJudgmentsEN());
            $processor -> replacePattern($prefix . 'Access_to_further_UA', $nationalFrameworkModel -> getAccessFurtherStudyUA());
            $processor -> replacePattern($prefix . 'Access_to_further_EN', $nationalFrameworkModel -> getAccessFurtherStudyEN());
            $processor -> replacePattern($prefix . 'Professional_status_UA', $nationalFrameworkModel -> getProfessionalStatusUA());
            $processor -> replacePattern($prefix . 'Professional_status_EN', $nationalFrameworkModel -> getProfessionalStatusEN());
            $processor -> replacePattern($prefix . 'TrainingStar', date("d.m.Y", strtotime($graduatesModels[$i] -> getTrainingStart())));
            $processor -> replacePattern($prefix . 'TrainingEnd', date("d.m.Y", strtotime($graduatesModels[$i] -> getTrainingEnd())));
            $processor -> replacePattern($prefix . 'DecisionDate', date("d.m.Y", strtotime($graduatesModels[$i] -> getDecisionDate())));
            $processor -> replacePattern($prefix . 'ProtNum', $graduatesModels[$i] -> getProtocolNum());
            $processor -> replacePattern($prefix . 'QualificationAwardedUA', $graduatesModels[$i] -> getQualificationAwardedUA());
            $processor -> replacePattern($prefix . 'QualificationAwardedEN', $graduatesModels[$i] -> getQualificationAwardedEN());
            $processor -> replacePattern($prefix . 'prevDocument_UA', $graduatesModels[$i] -> getPrevDocumentUA());
            $processor -> replacePattern($prefix . 'PrevSerialNumberAddition_EN', $graduatesModels[$i] -> getPrevSerialNumberAddition());
            $processor -> replacePattern($prefix . 'PrevSerialNumberAddition', $graduatesModels[$i] -> getPrevSerialNumberAddition());
            $processor -> replacePattern($prefix . 'IssuedBy', $graduatesModels[$i] -> getIssuedBy());
            $processor -> replacePattern($prefix . 'prevDocument_EN', $graduatesModels[$i] -> getPrevDocumentEN());
            $processor -> replacePattern($prefix . 'IssuedBy_EN', $graduatesModels[$i] -> getIssuedByEN());
            $table = new ODTTable($processor -> content);
            $estimatesModels = $estimateDao -> convertArrayToModels($estimateDao -> where(array('Graduat_ID'), array($graduatesModels[$i] -> getId()), array('=')));
//            var_dump($estimatesModels);
            $unitCode = 1;
            $this->addDisciplines($unitCode, $estimatesModels, 1, $disciplineDao, $table);
            $table -> addMergedRow('Практики/Practical training');
            $this->addDisciplines($unitCode, $estimatesModels, 2, $disciplineDao, $table);
            $table -> addMergedRow('Курсові роботи/Course papers');
            $this->addDisciplines($unitCode, $estimatesModels, 3, $disciplineDao, $table);
            $table -> addMergedRow('Атестації/Certification');
            $this->addDisciplines($unitCode, $estimatesModels, 4, $disciplineDao, $table);

            $processor -> content = $table -> content;
            $processor -> replacePattern($prefix . 'allcrd', $this->allCredits);
            $processor -> replacePattern($prefix . 'allhr', $this->allHours);




            $fileHandler -> createODTCopy($odt);
            $fileHandler -> writeContentToFile($processor -> content);
            $fileHandler -> setUpODTDocument($odt . '.odt');
//            var_dump($i);
        }

    }

    private function addDisciplines(int &$unitCode, array $estimatesModels, int $teaching, DisciplineDao $disciplineDao, Table $table) {

        for ($j = 0; $j < count($estimatesModels); $j++) {

            $disciplineModel = $disciplineDao -> convertArrayToModels($disciplineDao->where(array('Discipline_ID', 'Teaching'), array($estimatesModels[$j] -> getDisciplineId(), $teaching), array('=', '=')))[0];
            if ($disciplineModel === null) {
                continue;
            } else
            $table -> addRow($unitCode, $disciplineModel->getCourseTitleUa() . ' / ' . $disciplineModel -> getCourseTitleEN(), $disciplineModel->getLoans(), $disciplineModel->getHours(), $estimatesModels[$j] -> getEstimateNum(), $estimatesModels[$j] -> getEstimateUA(), $estimatesModels[$j] -> getEstimateChar());
            $unitCode++;
            $this -> allCredits += $disciplineModel->getLoans();
            $this-> allHours += $disciplineModel->getHours();
        }
    }

}