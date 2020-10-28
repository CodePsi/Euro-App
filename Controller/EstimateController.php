<?php


namespace Euro\Controller;


use Euro\Dao\EstimatesDao;
use Euro\Database\DBConnector;
use Euro\Model\IncorrectObjectTypeException;
use Euro\Model\NotFoundItemException;

class EstimateController
{

    public static function getEstimate($graduateId)
    {
        $dao = new EstimatesDao();
        echo json_encode($dao -> where(array("Graduat_ID"), array($graduateId), array('=')));
    }

    public static function updateEstimate($id, $estimateNum, $estimateChar, $estimateUA)
    {
        $dao = new EstimatesDao();
        try {
            $object = $dao->get($id);
            $object -> setEstimateNum($estimateNum);
            $object -> setEstimateChar($estimateChar);
            $object -> setEstimateUa($estimateUA);
//            var_dump($object);
            $dao -> update($object);
            if (DBConnector::$mysqli -> error !== '') {
//                echo DBConnector::$mysqli -> error;
                var_dump($object);
            }
        } catch (NotFoundItemException $e) {
        } catch (IncorrectObjectTypeException $e) {
        }
    }

    public static function getEstimatesByQualificationId($qualificationId) {

    }

}