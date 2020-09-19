<?php
namespace Euro;
use Euro\Controller\ContentsAndResultsController;
use Euro\Controller\DisciplineController;
use Euro\Controller\EstimateController;
use Euro\Controller\GraduatesController;
use Euro\Controller\NationalFrameworkController;
use Euro\Controller\PrintingController;
use Euro\Controller\QualificationController;
use Euro\Facades\Route;

use Euro\Render\View;
use Euro\Response\Redirect;
use Euro\Response\ResponseDataReceiver;
use Euro\Controller\LoginController;
use Euro\Secure\AuthorizationMiddleware;
use function Euro\Response\json;
use function Euro\Response\queryParameter;

require __DIR__ . "/../vendor/autoload.php";

Route::beforeEach(function (\Euro\Route\Route $to) {
    if (AuthorizationMiddleware::userAuthorized())
        return $to -> call();
    else if ($to -> getUri() !== '/euro_new/login' && $to -> getUri() !== '/euro_new/login/authorization'){
        Redirect::redirect('/euro_new/login');
    }
    return $to -> call();
});

Route::setRoute("/errorPage", function () {
    return new View("views/errorPage.html");
});

Route::setRoute("/euro_new/login", function () {
    return new View("views/loginPanel.html");
});

Route::setRoute("/euro_new/control-page", function () {
    return new View("views/mainPage.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/qualification", function () {
    return new View("views/editQualification.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/graduateList", function () {
    return new View("views/graduateList.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/disciplineList", function () {
    return new View("views/disciplineList.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/estimateList", function () {
    return new View("views/estimateList.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/contentsAndResults", function () {
    return new View("views/contentsAndResults.html");
});

Route::setRoute("/euro_new/control-page/group/edit/{id}/nationalFramework", function () {
    return new View("views/nationalFramework.html");
});

Route::post("/euro_new/login/authorization", function () {
    LoginController::login(json("login"), json("password"));
});

//Qualification's routes

Route::get("/euro_new/qualifications/", function () {
    if (queryParameter('id') !== null)
        $id = queryParameter('id');
    else
        $id = $_SESSION['user_id'];
    if ($_SESSION['is_admin'] === '1')
        QualificationController::getQualifications();
    else
        QualificationController::getUserQualifications($id);
//    print_r($_SESSION);
});

Route::get("/euro_new/qualifications/{id}", function ($id) {
    QualificationController::getQualification($id);

});

Route::post("/euro_new/qualifications", function () {
    QualificationController::addNewQualification();
});

Route::put("/euro_new/qualifications/{id}", function ($id) {
    QualificationController::updateQualification($id, json('abbreviation'), json('degree'), json('qualificationUA'), json('qualificationEN'), json('fieldOfStudyUA'), json('fieldOfStudyEN'), json('firstSpecialtyUA'), json('firstSpecialtyEN'), json('educationProgramUA'), json('educationProgramEN'), json('secondSpecialtyUA'), json('secondSpecialtyEN'), json('specializationUA'), json('specializationEN'));
});

//Graduates' routes
Route::get("/euro_new/graduates", function () {
    GraduatesController::getGraduates(queryParameter('qualificationId'));
});

Route::put("/euro_new/graduates", function () {
    GraduatesController::updateGraduate(json('id'), json('lastNameUA'), json('lastNameEN'), json('firstNameUA'), json('firstNameEN'), json('birthday'), json('serialOfDiploma'), json('numberOfDiploma'), json('numberAddition'), json('prevDocumentUA'), json('prevDocumentEN'), json('prevSerialNumberAddition'), json('durationOfTrainingUA'), json('durationOfTrainingEN'), json('trainingStart'), json('trainingEnd'), json('actualNumberOfEstimates'), json('decisionDate'), json('protocolNum'), json('qualificationAwardedUA'), json('qualificationAwardedEN'), json('issuedBy'), json('issuedByEN'));
});

Route::post("/euro_new/graduates", function () {
    GraduatesController::createNewGraduate(queryParameter('qualificationId'));
});

Route::delete("/euro_new/graduates", function () {
    GraduatesController::deleteGraduate(queryParameter('id'));
});

//Discipline's routes
Route::get("/euro_new/disciplines", function () {
    DisciplineController::getDisciplines(queryParameter('qualificationId'));
});

Route::put("/euro_new/disciplines", function () {
    DisciplineController::updateDiscipline(json('id'), json('courseTitleUA'), json('courseTitleEN'), json('loans'), json('hours'), json('teaching'), json('differential'));
});

Route::post("/euro_new/disciplines", function () {
    DisciplineController::createNewDiscipline(queryParameter('qualificationId'));
});

Route::delete("/euro_new/disciplines", function () {
    DisciplineController::deleteDiscipline(queryParameter('id'));
});

//Estimate's routes
Route::get("/euro_new/estimates", function () {
    EstimateController::getEstimate(queryParameter('graduateId'));
});

Route::put("/euro_new/estimates", function () {
    EstimateController::updateEstimate(json('id'), json('estimateNum'), json('estimateChar'), json('estimateUA'));
});

//Route::post("/euro_new/estimates", function () {
//    EstimateController::createNewEstimate(queryParameter('graduateId'), queryParameter('disciplineId'));
//});
//
//Route::delete("/euro_new/estimates", function () {
//    EstimateController::deleteEstimates(queryParameter('id'));
//});

Route::get("/euro_new/printing/{id}/odt", function ($id) {
    PrintingController::printOdtDocument($id);
});

//National Framework's routes

Route::get("/euro_new/nationalFrameworks/{id}", function ($id) {
    NationalFrameworkController::getNationalFramework($id);
});

Route::put("/euro_new/nationalFrameworks/{id}", function ($id) {
    NationalFrameworkController::updateNationalFramework($id, json('levelOfQualificationUA'), json('levelOfQualificationEN'), json('officialDurationProgrammeUA'), json('officialDurationProgrammeEN'), json('accessRequirementsUA'), json('accessRequirementsEN'), json('accessFurtherStudyUA'), json('accessFurtherStudyEN'), json('professionalStatusUA'), json('professionalStatusEN'));
});

//Content and result's routes

Route::get("/euro_new/contentsAndResults/{id}", function ($id) {
    ContentsAndResultsController::getContentAndResult($id);
});

Route::put("/euro_new/contentsAndResults/{id}", function ($id) {
    ContentsAndResultsController::updateContentAndResult($id, json('formOfStudyUA'), json('formOfStudyEN'), json('programSpecificationUA'), json('programSpecificationEN'), json('knowledgeUnderstandingUA'), json('knowledgeUnderstandingEN'), json('applicationKnowledgeUnderstandingUA'), json('applicationKnowledgeUnderstandingEN'), json('makingJudgmentsUA'), json('makingJudgmentsEN'));
});