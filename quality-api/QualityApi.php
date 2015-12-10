<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:47
 */

namespace quality;

include_once "apiRequests.php";
include_once "QualityInfo.php";
include_once "QualityInfoList.php";

use quality\QualityInfo as QualityInfo;

class QualityApi
{
    private $basePath = "localhost:8080/quality";

    /**
     * @param $id   The Quality ID to analyse
     * @return \QualityInfo the object corresponding to the ID
     */
    public function getQualityWithId($id) {
        $json = getCall($this->basePath . "/" . $id );
        return QualityInfo::create($json);
    }

    /**
     * @param $id   The Quality test ID to analyse
     * @return \QualityInfo the object corresponding to the ID
     */
    public function getQualityTestWithId($id) {
        $json = getCall($this->basePath . "/test/" . $id );
        return QualityTestInfo::create($json);
    }

    public function getQualityIds() {
        $json = getCall($this->basePath . "/list");
        return QualityInfoList::create($json);
    }

    public function getPlayerkey() {
        return "5bef380f-7e0d-4dc9-b027-52792d8385ec";
    }

    public static function getFormattedtiemString($ms) {
        if($ms < 1000) {
            return $ms . " ms";
        }
        else if($ms >= 1000 && $ms < 60000) {
            return $ms/1000 . " s";
        }
        else if($ms >= 60000 && $ms < 3600000) {
            return intval($ms/60000) . ":" . ($ms%60000)/1000;
        }
    }
}