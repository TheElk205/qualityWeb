<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 03:49
 */
require_once '../autoload.php';

use \quality\QualityApi as QualityApi;

$qualityApi = new QualityApi();

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
        <!-- menu -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/table.css">
        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/accordion.css">

        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="//bitmovin-a.akamaihd.net/bitdash/latest/bitdash.min.js"></script>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../charts/simpleGoogleBarChart.js"></script>

        <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/accordion.js">

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

        <!-- Player Akkordion -->
        <script>
            $(function() {
            $('.ui.accordion')
                .accordion({
                    collapsible: true
                })
            ;});
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
    </head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <?php if(isset($_GET['id'])) {
                $quality = $qualityApi->getQualityWithId($_GET['id']);
                ?>
                <!-- Basic Information -->
                <table class="ui definition celled right aligned table">
                    <tbody>
                    <tr>
                        <td class="left aligned">ID</td>
                        <td><?php echo $quality->id ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Original</td>
                        <td><?php echo "<a href='" . $quality->originalUrl . "'>" . shortenURL($quality->originalUrl) . "</a>"?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Representations</td>
                        <td><?php echo "<a href='" . $quality->mpdUrl . "'>" . shortenURL($quality->mpdUrl) . "</a>"?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Status</td>
                        <td><?php echo $quality->status ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">TimeNeeded</td>
                        <td><?php echo QualityApi::getFormattedtiemString($quality->timeNeeded) ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">#Threads</td>
                        <td><?php echo $quality->numberOfThreads ?></td>
                    </tr>
                    </tbody>
                </table>
                <!-- Represnetation Qualites -->
                <table class="ui right aligned celled table">
                    <thead>
                        <tr>
                            <th class="left aligned">Attributes</th>
                            <th colspan="<?php echo count($quality->results) ?>" style="text-align: center">Representations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="left aligned">Bitrate</td>
                            <?php foreach($quality->results as $res) {
                                echo "<td>" . $res->bitrate/1000 . " kbps</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">Time Needed</td>
                            <?php foreach($quality->results as $res) {
                                echo "<td>" . QualityApi::getFormattedtiemString($res->timeNeeded) . "</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">PSNR</td>
                            <?php foreach($quality->results as $res) {
                                echo "<td>" . $res->psnr . " dB</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">SSIM</td>
                            <?php foreach($quality->results as $res) {
                                if($res->ssim == "NaN") {
                                    echo "<td class='negative'>" . $res->ssim . "</td>";
                                }
                                else {
                                    echo "<td>" . $res->ssim . "</td>";
                                }
                            }?>
                        </tr>
                    </tbody>
                </table>
                <!-- Graphs Midvalues -->
                <div class="ui styled fluid accordion" >
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Quality Middle Values:
                    </div>
                    <div class="content" style="display: inline">
                        <div id='chart_psnr_div'></div>
                        <div id='chart_ssim_div'></div>
                    </div>
                </div>
                <!-- Bitdash Player -->
                <div class="ui styled fluid accordion">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Video
                    </div>
                    <div class="content" style="display: inline">
                        <div id="player"></div>
                    </div>
                </div>

                <script type="text/javascript">
                    <?php $qualityApi = new QualityApi(); ?>
                    var conf = {
                        key: "<?php echo $qualityApi->getPlayerkey()?>",
                        source:    {
                            dash: "<?php echo $quality->mpdUrl?>"
                        }
                    };
                    var player = bitdash('player');

                    player.setup(conf).then(function(value) {
                        // Success
                    }, function(reason) {
                        // Error!
                    });
                </script>
            <?php } else {echo "Id not set";}?>
        </div>
    </body>
</html>