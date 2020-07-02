<?php
namespace Icc;
use Euro\Controller\GraduatesController;
use Euro\Controller\QualificationController;
use Euro\Facades\Route;

use Euro\Render\View;
use Euro\Json\JSON;
use Euro\Controller\LoginController;
use function Euro\Json\json;
use function Euro\Json\queryParameter;

require __DIR__ . "/../vendor/autoload.php";

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

Route::post("/euro_new/login/authorization", function () {
    LoginController::login(json("login"), json("password"));
});

//Qualification's routes

Route::get("/euro_new/qualifications/", function () {
    if (json('id') !== null)
        $id = json('id');
    else
        $id = $_SESSION['user_id'];
    QualificationController::getUserQualifications($id);
//    print_r($_SESSION);
});

Route::get("/euro_new/qualifications/{id}", function ($id) {
    QualificationController::getQualification($id);
});

Route::put("/euro_new/qualifications/{id}", function ($id) {
    QualificationController::updateQualification($id, json('abbreviation'), json('degree'), json('qualificationUA'), json('qualificationEN'), json('fieldOfStudyUA'), json('fieldOfStudyEN'), json('firstSpecialtyUA'), json('firstSpecialtyEN'), json('educationProgramUA'), json('educationProgramEN'), json('secondSpecialtyUA'), json('secondSpecialtyEN'), json('specializationUA'), json('specializationEN'));
});

//Graduates' routes
Route::get("/euro_new/graduates", function () {
    GraduatesController::getGraduates(queryParameter('qualificationId'));
});

Route::put("/euro_new/graduates", function () {
    var_dump(JSON::$_JSON);
    GraduatesController::updateGraduate(json('id'), json('lastNameUA'), json('lastNameEN'), json('firstNameUA'), json('firstNameEN'), json('birthday'), json('serialOfDiploma'), json('numberOfDiploma'), json('numberAddition'), json('prevDocumentUA'), json('prevDocumentEN'), json('prevSerialNumberAddition'), json('durationOfTrainingUA'), json('durationOfTrainingEN'), json('trainingStart'), json('trainingEnd'), json('actualNumberOfEstimates'), json('decisionDate'), json('protocolNum'), json('qualificationAwardedUA'), json('qualificationAwardedEN'), json('issuedBy'), json('issuedByEN'));
});