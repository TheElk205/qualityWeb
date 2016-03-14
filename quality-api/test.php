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

?>
<html lang="en">
    <head>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.12/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crossfilter/1.3.12/crossfilter.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.js"></script>
        <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css">
        <link rel="stylesheet" type="text/css" src="../quality-api/charts/graphOverTime.css">
        <script src="../quality-api/charts/graphOverTime.js"></script>

        <script>
            $( document ).ready(function() {
                <?php
                    $general = $api->getQualityWithIdJson("testvideo");
                    $psnr = $api->getPSNROfIDJson("testvideo");
                    echo "createPSNRGraphOverTime('" . $general . "','" . $psnr . "','psnr_values',400,200);";
                ?>

            });
        </script>
        <title>Testgraph over Tiem PSNR</title>
    </head>
    <body>
        <div class="ui main text container">
            <div id="psnr_values"></div>
        </div>
    </body>
</html>