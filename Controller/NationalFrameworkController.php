<?php


namespace Euro\Controller;


use Euro\Dao\NationalFrameworkDao;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NationalFramework;
use Euro\Model\NotFoundItemException;

class NationalFrameworkController
{

    public static function getNationalFramework($id)
    {
        try {
            $dao = new NationalFrameworkDao();
            echo $dao->get($id)->toJson();
        } catch (NotFoundItemException $e) {
        }
    }

    public static function updateNationalFramework($id, $levelOfQualificationUA, $levelOfQualificationEN, $officialDurationProgrammeUA, $officialDurationProgrammeEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN)
    {
        try {
            $nationalFrameworkDao = new NationalFrameworkDao();
            $entry = new NationalFramework($id, $levelOfQualificationUA, $levelOfQualificationEN, $officialDurationProgrammeUA, $officialDurationProgrammeEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN);
            $nationalFrameworkDao->update($entry);
        } catch (IncorrectObjectTypeException $e) {
            echo $e;
        }
    }
}