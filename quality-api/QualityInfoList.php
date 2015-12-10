<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 10.12.2015
 * Time: 00:16
 */

namespace quality;

include_once "ApiResource.php";
include_once "RepresentationInfo.php";

use quality\ApiResource as ApiResource;
use quality\RepresentationInfo as RepresentationInfo;

class QualityInfoList extends ApiResource
{
    /**
     * @var number of qualities
     */
    public $count;

    /**
     * @varlist of all qualities
     */
    public $qualities;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
        $this->castQualities();
    }

    public function castQualities()
    {
        $this->qualities;
        $i = 0;
        if ($this->qualities != null) {
            foreach ($this->qualities as $res) {
                $this->qualities[$i] = new QualityInfo($res);
                $i = $i + 1;
            }
        }
    }

    public function getAllIds() {
        $ids = array();
        $i = 0;
        foreach($this->qualities as $q) {
            $ids[$i] = $q->id;
            $i += 1;
        }
        return $ids;
    }

    /**
     * @param $json The Jsonstirng for the qualityInfoList
     * @return QualityInfoList the object
     */
    public static function create($json) {
        return new self(json_decode($json));
    }


}