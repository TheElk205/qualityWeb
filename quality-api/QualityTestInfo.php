<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 17:22
 */

namespace quality;

include_once "ApiResource.php";
include_once "RepresentationInfo.php";

use quality\ApiResource as ApiResource;
use quality\RepresentationInfo as RepresentationInfo;

class QualityTestInfo extends ApiResource
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var String
     */
    public $status;
    /**
     * @var int
     */
    public $timeNeeded;
    /**
     * @var array of QualityInfo
     */
    public $results;

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
                $this->results[$i] = new QualityInfo($res);
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