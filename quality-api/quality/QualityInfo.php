<?php

/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:36
 */

namespace quality;

require_once 'RepresentationInfo.php';

class QualityInfo extends ApiResource
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var enum STATUS, so here basically a String
     */
    public $status;

    /**
     * @var double percentage of the current calculation progress
     */
    public $percentage;

    /**
     * @var int
     */
    public $timeNeeded;

    /**
     * @var int
     */
    public $numberOfThreads;

    /**
     * @var int
     */
    public $numberOfFrames;

    /**
     * @var Stirng
     */
    public $originalUrl;

    /**
     * @var String
     */
    public $mpdUrl;

    /**
     * @var array of representationInfo
     */
    public $results;

    /**
     * @var contains all PSNR Values fro each frame
     */
    public $psnrFrames;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
        $this->castResults();
        $this->psnrFrames = array();
    }

    public function castResults()
    {
        if($this->status == "FINISHED") {
            $this->results;
            $i = 0;
            if ($this->results != null) {
                foreach ($this->results as $res) {
                    $this->results[$i] = new RepresentationInfo($res);
                    $i = $i + 1;
                }
            }
        }
        else {
            //echo "Not casting results";
        }
    }

    /**
     * @param $json The Jsonstirng for the quality
     * @return QualityInfo the object
     */
    public static function create($json) {
        return new self(json_decode($json));
    }

    public function addPSNRValues($psnr) {
        array_push($this->psnrFrames,$psnr);
    }
}