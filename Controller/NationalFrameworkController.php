<?php


namespace Euro\Controller;


use Euro\Dao\NationalFrameworkDao;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NationalFramework;

class NationalFrameworkController
{

    public static function getNationalFramework($id)
    {
    }

    public static function updateNationalFramework($id, $levelOfQualificationUA, $levelOfQualificationEN, $officialDurationProgrammeUA, $officialDurationProgrammeEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN)
    {
        $nationalFrameworkDao = new NationalFrameworkDao();
        $entry = new NationalFramework($id, $levelOfQualificationUA, $levelOfQualificationEN, $officialDurationProgrammeUA, $officialDurationProgrammeEN, $accessRequirementsUA, $accessRequirementsEN, $accessFurtherStudyUA, $accessFurtherStudyEN, $professionalStatusUA, $professionalStatusEN);
        try {
            $nationalFrameworkDao->update($entry);
        } catch (IncorrectObjectTypeException $e) {
        }
    }
}