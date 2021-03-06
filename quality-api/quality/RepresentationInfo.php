<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:38
 */

namespace quality;

//require_once '../autoload.php';
require_once 'ApiResource.php';

class RepresentationInfo extends ApiResource
{
    /**
     * @var int
     */
    public $width;

    /**
     * @var int
     */
    public $height;

    /**
     * @var int
     */
    public $bitrate;

    /**
     * @var double
     */
    public $psnr;

    /**
     * @var double
     */
    public $ssim;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
    }

}