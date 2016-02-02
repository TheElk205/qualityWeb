<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 03:49
 */
require_once '../quality/QualityApi.php';

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
    </head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <!-- Selector -->
            <form action="ShowQuality.php" method="get" >
                <div class="ui selection dropdown" style="width: 60%">
                    <input type="hidden" name="id" >
                    <i class="dropdown icon"></i>
                    <div class="default text">ID</div>
                    <div class="menu">
                        <?php foreach($qualityApi->getQualityIds()->getAllIds() as $id) {
                            echo "<div class='item' data-value='" . $id . "'>" . $id . "</div>";
                        }?>

                    </div>
                </div>
                <button class="ui primary button">
                    Show
                </button>
            </form>
            <?php if(isset($_GET['id'])) {
                $qualityTest = $qualityApi->getQualityWithId($_GET['id']);
                ?>
                <h1 class="ui header">Show Quality</h1>
                <!-- Basic Information -->
                <table class="ui definition celled right aligned table">
                    <tbody>
                    <tr>
                        <td class="left aligned">ID</td>
                        <td><?php echo $qualityTest->id ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Original</td>
                        <td><?php echo "<a href='" . $qualityTest->originalUrl . "'>" . shortenURL($qualityTest->originalUrl) . "</a>"?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Representations</td>
                        <td><?php echo "<a href='" . $qualityTest->mpdUrl . "'>" . shortenURL($qualityTest->mpdUrl) . "</a>"?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Status</td>
                        <?php
                        if($qualityTest->status == "FINISHED") {
                            echo "<td class='positive'>".$qualityTest->status . "</td>";
                        }
                        else if($qualityTest->status == "ERROR") {
                            echo "<td class='negative'>".$qualityTest->status . "</td>";
                        }
                        else {
                            echo "<td class='warning'>" . $qualityTest->status . "</td>";
                        }
                        ?>

                    </tr>
                    <tr>
                        <td class="left aligned">#Threads</td>
                        <td><?php echo $qualityTest->numberOfThreads ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">TimeNeeded</td>
                        <td><?php echo QualityApi::getFormattedtiemString($qualityTest->timeNeeded) ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">#Frames</td>
                        <td><?php echo $qualityTest->numberOfFrames ?></td>
                    </tr>
                    <tr>
                        <td class="left aligned">Time / Frame</td>
                        <td><?php echo QualityApi::getFormattedtiemString($qualityTest->timeNeeded/ $qualityTest->numberOfFrames) ?></td>
                    </tr>
                    </tbody>
                </table>
                <?php if($qualityTest->status == "FINISHED") { ?>

                <!-- Represnetation Qualites -->
                <table class="ui right aligned celled table">
                    <thead>
                        <tr>
                            <th class="left aligned">Attributes</th>
                            <th colspan="<?php echo count($qualityTest->results) ?>" style="text-align: center">Representations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="left aligned">Bitrate</td>
                            <?php foreach($qualityTest->results as $res) {
                                echo "<td>" . $res->bitrate/1000 . " kbps</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">Width</td>
                            <?php foreach($qualityTest->results as $res) {
                                echo "<td>" . $res->width . "</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">Height</td>
                            <?php foreach($qualityTest->results as $res) {
                                echo "<td>" . $res->height . "</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">PSNR</td>
                            <?php foreach($qualityTest->results as $res) {
                                echo "<td>" . $res->psnr . " dB</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">SSIM</td>
                            <?php foreach($qualityTest->results as $res) {
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

                <!-- Representation quality values -->
                <div class="ui styled fluid accordion" style="margin-bottom: 16px;margin-top: 16px">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Qualities of each representation
                    </div>
                    <div class="content" style="display: inline">
                        <div id='chart_psnr_div'></div>
                        <div id='chart_ssim_div'></div>
                    </div>
                </div>

                <!-- Representation quality values over time-->
                <!-- <div class="ui styled fluid accordion" style="margin-bottom: 16px;margin-top: 16px">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Qualities of each representation
                    </div>
                    <div class="content" style="display: inline">
                        <div id='chart_psnr_time_div'></div>
                    </div>
                </div> -->

                <!-- Bitdash Player -->
                <div class="ui styled fluid accordion"  style="margin-bottom: 16px;margin-top: 16px">
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
                            dash: "<?php echo $qualityTest->mpdUrl?>"
                        }
                    };
                    var player = bitdash('player');

                    player.setup(conf).then(function(value) {
                        // Success
                    }, function(reason) {
                        // Error!
                    });
                </script>
            <?php } } ?>
        </div>
    </body>
</html>