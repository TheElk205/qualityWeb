<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 13.12.2015
 * Time: 19:39
 */

namespace quality;


class QualityPSNRFrames extends ApiResource
{
    /**
     * @var number of Identical Frames
     */
    public $identicalFrames;

    /**
     * @var bitrate in bps
     */
    public $bitrate;

    /**
     * @var Middle Value
     */
    public $reuslt;

    /**
     * @var PSNR vlaues for each frame
     */
    public $results;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
    }

    /**
     * @param $json The Jsonstirng for the quality
     * @return QualityInfo the object
     */
    public static function create($json) {
        return new self(json_decode($json));
    }

}