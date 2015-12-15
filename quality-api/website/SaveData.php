<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 15.12.2015
 * Time: 11:27
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 03:49
 */
require_once '../autoload.php';

use \quality\QualityApi as QualityApi;


function shortenURL($url) {
    $offset = 0;
    if(stringStartsWith($url,"https")) {
        $offset = 9;
    }
    else if(stringStartsWith($url,"http")) {
        $offset = 8;
    }
    $main = substr($url,0,strpos($url,"/",$offset));
    $file = strrchr($url,"/");
    return $main . "/..." . $file;
}

function stringStartsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
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
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/table.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/accordion.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/dropdown.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/transition.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/button.css">

        <script type="text/javascript" src="../../Semantic-UI-master/dist/components/accordion.js"></script>
        <script type="text/javascript" src="../../Semantic-UI-master/dist/components/dropdown.js"></script>
        <script type="text/javascript" src="../../Semantic-UI-master/dist/components/transition.js"></script>

        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/label.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/button.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/input.css">

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../charts/simpleGoogleBarChart.js"></script>

        <style type="text/css">
            body {
                background-color: #FFFFFF;
            }
            }
            .ui.menu .item img.logo {
                margin-right: 1.5em;
            }
            .main.container {
                margin-top: 7em;
            }
            .wireframe {
                margin-top: 2em;
            }
            .ui.footer.segment {
                margin: 5em 0em 0em;
                padding: 5em 0em;
            }
        </style>

        <!-- accordion -->
        <script>
            $(function() {
                $('.ui.accordion')
                    .accordion({
                        collapsible: true,
                        active: false
                    })
                ;});
        </script>

        <!-- Dropdown -->
        <script>
            $(function() {
                $('.ui.dropdown')
                    .dropdown()
                ;
            });
        </script>

        <!-- Graphs Middle values -->
        <script>
            google.load('visualization', '1', {packages: ['corechart', 'bar']});
            google.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                <?php
                if (isset($_GET['id'])) {
                    $answer = $qualityApi->getQualityWithId($_GET["id"]);
                    if ($answer->status == "FINISHED") {
                        $psnrDataContent = "[['', 'PSNR Values'],";
                        $ssimDataContent = "[['', 'SSIM Values'],";

                        if ($answer->results != null) {
                            foreach ($answer->results as $res) {
                                $psnrDataContent = $psnrDataContent . "['" . $res->bitrate . "'," . $res->psnr . "],";
                                $ssimDataContent = $ssimDataContent . "['" . $res->bitrate . "'," . $res->ssim . "],";
                            }

                        }
                        $psnrDataContent = substr($psnrDataContent, 0, -1);
                        $psnrDataContent = $psnrDataContent . "]";
                        $ssimDataContent = substr($ssimDataContent, 0, -1);
                        $ssimDataContent = $ssimDataContent . "]";

                        echo "var dataPSNR = " . $psnrDataContent . ";";
                        echo "dataSSIM = " . $ssimDataContent . ";";
                        echo "drawSimpleBarchart(dataPSNR, 'PSNR Values of all Representations', 'Bitrate', 'PSNR in dB', 'chart_psnr_div');
                                    drawSimpleBarchart(dataSSIM, 'SSIM Values of all Representations', 'Bitrate', 'PSNR in dB', 'chart_ssim_div');";
                    }
                }?>
            }
        </script>

        <!-- Graphs Over time -->
        <!-- <script>
                google.load('visualization', '1', {packages: ['corechart', 'line']});
                google.setOnLoadCallback(drawCurveTypes);

                function drawCurveTypes() {
                    <?php if (isset($_GET['id'])) {
            $qualityId = $qualityApi->getQualityWithId($_GET["id"]);
            echo "var data = new google.visualization.DataTable();";
            echo "data.addColumn('number', 'Frame');";
            foreach ($qualityId->results as $res) {
                echo "data.addColumn('number', '" . $res->bitrate / 1000 . " kbps');";
            }
            echo "data.addRows(";
            $data = "[";
            for ($i = 0; $i < $qualityId->numberOfFrames; $i++) {
                $data .= "[" . $i . ",";
                //var_dump($quality->psnrFrames->results);
                foreach ($qualityId->psnrFrames->results as $res) {
                    $data .= $res->results[$i] . ",";
                }
                $data = substr($data, 0, -1) . "],";
            }
            $data = substr($data, 0, -1) . "]";
            echo $data . ");";
            echo "var options = {
                                hAxis: {
                                title: 'Time'
                                },
                                vAxis: {
                                    title: 'Popularity'
                                },
                                series: {
                                    1: {curveType: 'function'}
                                }
                            };

                        var chart = new google.visualization.LineChart(document.getElementById('chart_psnr_time_div'));
                        chart.draw(data, options);";
        }?>
                }
            </script> -->
</head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <form class="ui large form" name="createQuality" action="download.php">
                <button class="ui button" style="width: 100%">Download</button>
            </form>
        </div>
    </body>
</html>
