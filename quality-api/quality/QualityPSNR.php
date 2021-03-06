<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 13.12.2015
 * Time: 19:47
 */

namespace quality;

class QualityPSNR extends ApiResource
{
    public $id;

    public $status;

    public $results;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
        $this->castResults();
    }

    public function createFromJson(\stdClass $class) {
        parent::__construct($class);
        $this->castResults();
    }

    public function castResults()
    {
        $this->results;
        $i = 0;
        if ($this->results != null) {
            foreach ($this->results as $res) {
                $this->results[$i] = new QualityPSNRFrames($res);
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

    public static function createEmpty() {
        return new self(null);
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function initValues() {
        $this->results = array();
    }

    public function addValue($value) {
        array_push($this->results,$value);
    }
}