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
    if(!isset($_GET['numberOfThreads'])) {
        $_GET['numberOfThreads'] = 1;
    }
    if(!isset($_GET['numberOfFrames'])) {
        $_GET['numberOfFrames'] = -1;
    }

    //create Quality
    $id = $api->createQuality($_GET['originalUrl'],$_GET['mpdUrl'],$_GET['numberOfThreads'],$_GET['numberOfFrames']);

    //Evaluate Result
    if($id != -1) {
        $_GET = array();
        header("Location: http:ShowQuality.php?id=" . $id);
    }
    else {
        $_GET['error'] = '1';
        header("Location: http:AddQuality.php?originalUrl=" . $_GET['originalUrl'] . "&mpdUrl=" . $_GET['mpdUrl'] . "&error=" . $_GET['error']);
    }
}
else {
    $_GET['error'] = '1';
    header("Location: http:AddQuality.php?originalUrl=" . $_GET['originalUrl'] . "&mpdUrl=" . $_GET['mpdUrl'] . "&error=" . $_GET['error']);
}