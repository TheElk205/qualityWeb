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

$data = array();
$count = array();
$midValues = array();

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
                    active: true
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
                        $answer = $qualityApi->getQualityTestWithId($_GET['id']);
                        //reading Data from JSonanswer
                        foreach($answer->results as $res) {
                            if (array_key_exists($res->numberOfThreads, $data)) {
                                $data[$res->numberOfThreads] = $data[$res->numberOfThreads] + $res->timeNeeded;
                                $count[$res->numberOfThreads] = $count[$res->numberOfThreads]  + 1;
                            }
                            else {
                                $data[$res->numberOfThreads] = $res->timeNeeded;
                                $count[$res->numberOfThreads] = 1;
                            }
                        }

                        //Calculating Midvalues
                        foreach($data as $nThreads => $value) {
                            $midValues[$nThreads] = $value / $count[$nThreads] /1000;
                        }

                        $dataString = "[['', 'Time in ms'],";
                        foreach($midValues as $nThreads => $value) {
                            $dataString .= "['" . $nThreads . "'," . $value . "],";
                        }
                        $dataString = substr($dataString,0,-1);
                        $dataString .= "]";

                        echo "var data = " . $dataString . ";";
                        echo "drawSimpleBarchart(data, 'Middle Values per Threadcount of timeNeeded', '#Threads', 'timeNeeded in s', 'chart_div');";
                    }
                ?>
            }
        </script>
    </head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <!-- Selector -->
            <form action="ShowQualityTest.php" method="get">
                <div class="ui selection dropdown" style="width: 60%">
                    <input type="hidden" name="id">
                    <i class="dropdown icon"></i>
                    <div class="default text">ID</div>
                    <div class="menu">
                        <?php foreach($qualityApi->getQualityTestIds()->getAllIds() as $id) {
                            echo "<div class='item' data-value='" . $id . "'>" . $id . "</div>";
                        }?>
                    </div>
                </div>
                <button class="ui primary button">
                    Show
                </button>
            </form>
            <?php if(isset($_GET['id'])) {
                $qualityTest = $qualityApi->getQualityTestWithId($_GET['id']);
                ?>
                <h1 class="ui header">Show Quality Test</h1>
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
                        <td class="left aligned">TimeNeeded</td>
                        <td><?php echo QualityApi::getFormattedtiemString($qualityTest->timeNeeded) ?></td>
                    </tr>
                    </tbody>
                </table>
                <?php if($qualityTest->status == "FINISHED") { ?>
                <!-- Thread Information -->
                <table class="ui right aligned celled table">
                    <thead>
                        <tr>
                            <th class="left aligned">Attributes</th>
                            <?php
                            $number= 1;
                            foreach($qualityTest->results as $result) {
                                echo "<th>Test " . $number . "</th>";
                                $number += 1;
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#Threads</td>
                            <?php
                            foreach($qualityTest->results as $result) {
                                echo "<td>" . $result->numberOfThreads .  "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>#Frames</td>
                            <?php
                            foreach($qualityTest->results as $result) {
                                echo "<td>" . $result->numberOfFrames .  "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Time Needed</td>
                            <?php
                            foreach($qualityTest->results as $result) {
                                echo "<td>" . QualityApi::getFormattedtiemString($result->timeNeeded) .  "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Time/Frames</td>
                            <?php
                            foreach($qualityTest->results as $result) {
                                echo "<td>" . QualityApi::getFormattedtiemString($result->timeNeeded/$result->numberOfFrames) .  "</td>";
                            }
                            ?>
                        </tr>
                    </tbody>
                    <!-- Represnetation Qualites of element 0 -->
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
                            <?php foreach($qualityTest->results[0]->resultsRepresentations as $res) {
                                echo "<td>" . $res->bitrate/1000 . " kbps</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">Time Needed</td>
                            <?php foreach($qualityTest->results[0]->resultsRepresentations as $res) {
                                echo "<td>" . QualityApi::getFormattedtiemString($res->timeNeeded) . "</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">PSNR</td>
                            <?php foreach($qualityTest->results[0]->resultsRepresentations as $res) {
                                echo "<td>" . $res->psnr . " dB</td>";
                            }?>
                        </tr>
                        <tr>
                            <td class="left aligned">SSIM</td>
                            <?php foreach($qualityTest->results[0]->resultsRepresentations as $res) {
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
                </table>

                <!-- Graphs Midvalues -->
                <div class="ui styled fluid accordion" style="margin-bottom: 16px;margin-top: 16px">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Quality Middle Values
                    </div>
                    <div class="content" style="display: inline; width: 100%">
                        <div id='chart_div'></div>
                    </div>
                </div>

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