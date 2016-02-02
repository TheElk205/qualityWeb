<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:47
 */

namespace quality;

// die gehen nciht über Autoload weg
require_once 'apiRequests.php';
require_once 'QualityInfo.php';
require_once 'QualityPSNR.php';
require_once 'QualityInfoList.php';

class QualityApi
{
    private $basePath = "localhost:8080/quality";

    /**
     * @param $id   The Quality ID to analyse
     * @return \QualityInfo the object corresponding to the ID
     */
    public function getQualityWithId($id)
    {
        $json = getCall($this->basePath . "/" . $id);
        $quality = QualityInfo::create($json);

        $json = getcall($this->basePath . "/" . $id . "/psnr");
        if ($quality->status == "FINISHED") {
            $psnr = QualityPSNR::create($json);
            $quality->psnrFrames = $psnr;
        }
        return $quality;
    }

    public function getQualityWithIdJson($id) {
        return getCall($this->basePath . "/" . $id );
    }

    public function getPSNROfIDJson($id) {
        return getcall($this->basePath . "/" . $id . "/psnr");
    }

    public function getSSIMOfIDJson($id) {
        return getcall($this->basePath . "/" . $id . "/ssim");
    }

    /**
     * @param $id   The Quality test ID to analyse
     * @return \QualityInfo the object corresponding to the ID
     */
    public function getQualityTestWithId($id) {
        $json = getCall($this->basePath . "/test/" . $id );
        return QualityTestInfo::create($json);
    }

    public function getQualityTestWithIdJson($id) {
        return getCall($this->basePath . "/test/" . $id );
    }

    public function getQualityIds() {
        $json = getCall($this->basePath . "/list");
        return QualityInfoList::create($json);
    }

    public function getQualityIdsJson() {
        return getCall($this->basePath . "/list");
    }

    public function getQualityTestIds() {
        $json = getCall($this->basePath . "/test/list");
        return QualityTestInfoList::create($json);
    }

    public function getQualityTestIdsJson() {
        return getCall($this->basePath . "/test/list");
    }

    public function getPlayerkey() {
        return "5bef380f-7e0d-4dc9-b027-52792d8385ec";
    }

    public static function getFormattedtiemString($ms) {
        $msPrecision = 3;
        if($ms < 1000) {
            return round($ms,$msPrecision) . " ms";
        }
        else if($ms >= 1000 && $ms < 60000) {
            return round($ms/1000,$msPrecision) . " s";
        }
        else if($ms >= 60000 && $ms < 3600000) {
            return intval($ms/60000) . ":" . round(($ms%60000)/1000,$msPrecision);
        }
    }

    public function createQuality($originalUrl, $mpdUrl, $numberOfThreads, $numberOfFrames) {
        $fields = array(
            'source' => $originalUrl,
            'mpd' => $mpdUrl,
            'numberOfThreads' => $numberOfThreads,
            'numberOfFrames' => $numberOfFrames,
        );
        $url = $this->basePath . "/dash";
        $json = postCall($url,$fields);
        $id = json_decode($json)->{"id"};
        return $id;
    }

    public function createQualityTest($originalUrl, $mpdUrl, $threadCountMin, $threadCountMax, $threadStepSize, $threadRepetitons) {
        $fields = array(
            'source' => $originalUrl,
            'mpd' => $mpdUrl,
            'threadCountMin' => $threadCountMin,
            'threadCountMax' => $threadCountMax,
            'threadStepSize' => $threadStepSize,
            'threadRepetitons' => $threadRepetitons
        );
        $url = $this->basePath . "/dash/test";
        return postCall($url,$fields);
    }

    public function getDCJSDataWithId($id) {
        /*
           [
                {frame: 0, b4000: 43.34, b8000: 50.6},
                {frame: 1, b4000: 45.34, b8000: 51.6},
                {frame: 2, b4000: 42.34, b8000: 49.6},
                {frame: 3, b4000: 46.34, b8000: 52.6},
                {frame: 4, b4000: 41.34, b8000: 48.6},
                {frame: 5, b4000: 47.34, b8000: 53.6},
                {frame: 6, b4000: 40.34, b8000: 47.6},
                {frame: 7, b4000: 43.34, b8000: 50.6}
            ]
         */
        //->psnrFrames->results[0]->results
        $quality = $this->getQualityWithId($id);
        $string = "[";
        $max = 10;
        for($frame = 0; $frame < count($quality->psnrFrames->results[0]->results); $frame++) {
            $string .= "\n{frame: " . $frame . ", ";
            for($bitrate = 0; $bitrate < count($quality->psnrFrames->results); $bitrate++) {
                $string .= "b" . $bitrate . ": " . $quality->psnrFrames->results[$bitrate]->results[$frame];
                if($bitrate < count($quality->psnrFrames->results)-1) {
                    $string .= ", ";
                }
                else {
                    $string .= "}";
                }
            }
            $max--;
            /*if($max == 0) {
                break;
            }*/

            if($frame < count($quality->psnrFrames->results[0]->results)-1) {
                $string .= ", ";
            }
        }
        $string .= "]";
        return $string;
    }
}