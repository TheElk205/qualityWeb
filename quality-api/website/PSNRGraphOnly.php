<?php
/**
 * Created by PhpStorm.
 * User: ferdinand
 * Date: 2/28/16
 * Time: 4:24 PM
 */

require_once '../quality/QualityApi.php';

use \quality\QualityApi as QualityApi;

$qualityApi = new QualityApi();
$currentId = null;
if(isset($_GET["id"])) {
    $currentId = $_GET["id"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="//bitmovin-a.akamaihd.net/bitdash/latest/bitdash.min.js"></script>

    <!-- menu -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../styles/main.css">

    <script type="text/javascript" src="../../Semantic-UI-master/dist/components/accordion.js"></script>
    <script type="text/javascript" src="../../Semantic-UI-master/dist/components/dropdown.js"></script>
    <script type="text/javascript" src="../../Semantic-UI-master/dist/components/transition.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="../charts/simpleGoogleBarChart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.12/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crossfilter/1.3.12/crossfilter.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css">

    <script src="../charts/graphOverTime.js"></script>

    <!-- frames over time -->
    <script>
        $( document ).ready(function() {
            <?php
            if(isset($currentId)) {
                $general = $qualityApi->getQualityWithIdJson($currentId);
                $psnr = $qualityApi->getPSNROfIDJson($currentId);
                //echo "createPSNRGraphOverTime('" . $general . "','" . $psnr . "','chart_psnr_over_frames',600,200);";
                echo "createPSNRGraphOverTime2('" . json_encode($qualityApi->getQualityWithId($currentId)) . "','chart_psnr_over_frames',1800,1080);";
            }
            ?>
        });


    </script>

    </head>
<body>
    <div id='chart_psnr_over_frames' ></div>
</body>
</html>