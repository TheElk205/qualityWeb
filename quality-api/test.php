<?php
/**
 * Created by PhpStorm.
 * User: ferdi
 * Date: 02.02.16
 * Time: 15:21
 */

//include_once "../autoload.php";
include_once "quality/QualityApi.php";

$api = new \quality\QualityApi();
;
//var_dump($api->getQualityWithId("testvideo"));
$api->getDCJSDataWithId("testvideo");