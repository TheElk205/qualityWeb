<?php

/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:36
 */

namespace quality;

include_once "ApiResource.php";
include_once "RepresentationInfo.php";

use quality\ApiResource as ApiResource;
use quality\RepresentationInfo as RepresentationInfo;

class QualityInfo extends ApiResource
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var array of representationInfo
     */
    public $results;
    /**
     * @var enum STATUS, so here basically a String
     */
    public $status;
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

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
        $this->castResults();
    }

    public function castResults()
    {
        $this->results;
        $i = 0;
        if ($this->results != null) {
            foreach ($this->results as $res) {
                $this->results[$i] = new RepresentationInfo($res);
                $i = $i + 1;
            }
        }
    }

    /**
     * @param $json The Jsonstirng for the quality
     * @return QualityInfo the object
     */
    public static function create($json) {
        return new self(json_decode($json));
    }
}