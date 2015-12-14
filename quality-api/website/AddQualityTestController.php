<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 03:29
 */

require_once '../autoload.php';

use \quality\QualityApi as QualityApi;

if((isset($_GET['originalUrl']) && isset($_GET['mpdUrl'])) && (strlen($_GET['originalUrl']) > 0 && strlen($_GET['mpdUrl']) > 0)) {
    $api = new QualityApi();
    if(!isset($_GET['threadCountMin'])) {
        $_GET['threadCountMin'] = 1;
    }
    if(!isset($_GET['threadCountMax'])) {
        $_GET['threadCountMax'] = 1;
    }
    if(!isset($_GET['threadStepSize'])) {
        $_GET['threadStepSize'] = 1;
    }
    if(!isset($_GET['threadRepetitons'])) {
        $_GET['threadRepetitons'] = 1;
    }

    //create Quality
    $id = $api->createQualityTest($_GET['originalUrl'], $_GET['mpdUrl'], $_GET['threadCountMin'], $_GET['threadCountMax'], $_GET['threadStepSize'], $_GET['threadRepetitons']);

    //Evaluate Result
    if($id != -1) {
        $_GET = array();
        header("Location: http:ShowQualityTest.php?id=" . $id);
    }
    else {
        $_GET['error'] = '1';
        header("Location: http:AddQualityTest.php?originalUrl=" . $_GET['originalUrl'] . "&mpdUrl=" . $_GET['mpdUrl'] . "&error=" . $_GET['error']);
    }
}
else {
    $_GET['error'] = '1';
    header("Location: http:AddQualityTest.php?originalUrl=" . $_GET['originalUrl'] . "&mpdUrl=" . $_GET['mpdUrl'] . "&error=" . $_GET['error']);
}