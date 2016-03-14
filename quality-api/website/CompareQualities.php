<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 15.12.2015
 * Time: 18:45
 */

require_once '../quality/QualityApi.php';
use quality\QualityApi as QualityApi;

$ids = array();
if(isset($_GET['ids'])) {
    $ids = $_GET['ids'];
}
if( count($ids) < 2 || count($ids) > 3) {
    header("Location: http:ShowAllQualities.php");
}

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

function filenameFromURL($url) {
    $file = strrchr($url,"/");
    return  $file;
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

    </head>
    <body>
        <?php include 'menu.php'?>
        <?php
        $qualites = array();
        foreach($ids as $id) {
            array_push($qualites, $qualityApi->getQualityWithId($id));
        }
        ?>
        <div class="ui main text container">
            <table class="ui celled table fixed single line">
                <thead>
                    <tr>
                        <th>Attributes</th>
                        <?php foreach($qualites as $quality) {
                            echo "<th colspan='" . count($quality->results) . "'><a href='ShowQuality.php?id=". $quality->id . "'>" . $quality->id . "</a></th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>URL</td>
                        <?php foreach($qualites as $quality) {
                            echo "<td colspan='" . count($quality->results) . "'>". filenameFromURL($quality->originalUrl) . "</td>";
                        }?>
                    </tr>
                    <tr>
                        <td>#Frames</td>
                        <?php foreach($qualites as $quality) {
                            echo "<td colspan='" . count($quality->results) . "'>". $quality->numberOfFrames . "</td>";
                        }?>
                    </tr>
                    <tr>
                        <td>#Threads</td>
                        <?php foreach($qualites as $quality) {
                            echo "<td colspan='" . count($quality->results) . "'>". $quality->numberOfThreads . "</td>";
                        }?>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <?php foreach($qualites as $quality) {
                            echo "<td colspan='" . count($quality->results) . "'>". QualityApi::getFormattedtiemString($quality->timeNeeded) . "</td>";
                        }?>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach($qualites as $quality) {
                            echo "<th colspan='" . count($quality->results) . "'>Representations</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bitrate</td>
                        <?php foreach($qualites as $quality) {
                            foreach($quality->results as $res) {
                                echo "<td>" . $res->bitrate . "</td>";
                            }
                        }?>
                    </tr>
                    <tr>
                        <td>PSNR</td>
                        <?php foreach($qualites as $quality) {
                            foreach($quality->results as $res) {
                                echo "<td>" . round($res->psnr,4) . " dB</td>";
                            }
                        }?>
                    </tr>
                    <tr>
                        <td>SSIM</td>
                        <?php foreach($qualites as $quality) {
                            foreach($quality->results as $res) {
                                echo "<td>" . $res->ssim. "</td>";
                            }
                        }?>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>