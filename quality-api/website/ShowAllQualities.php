<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 15.12.2015
 * Time: 17:44
 */
require_once '../quality/QualityApi.php';


$qualityApi = new quality\QualityApi();

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

        <!-- compare Items -->
        <script>
            var cBIds = [
                <?php
                    $data = "";
                    $qualities = $qualityApi->getQualityIds();
                    foreach($qualities->qualities as $quality) {
                        $data .= "\"cB_" . $quality->id . "\",";
                    }
                    echo substr($data,0,-1);
                ?>
            ];
            console.log(<?php echo substr($data,0,-1) ?>);
            function compare() {
                var i, len = cBIds.length, count = 0;
                var params = "";
                for( i = 0; i < len; i++) {
                    if(document.getElementById(cBIds[i]).checked == true) {
                        console.log("Selected : " + cBIds[i] + "\n");
                        params += "ids[]=" + cBIds[i].substr(3) + "&";
                        count++;
                    }
                }
                if(count < 2 || count > 3) {
                    alert("Only min 2 and max. 3 Qualites can be compared");
                }
                else {
                    window.location.href = "http:CompareQualities.php?" + params;
                }
            }
        </script>
    </head>
    <body>
    <?php include 'menu.php'?>
    <div class="ui main text container">

        <?php
            $qualities = $qualityApi->getQualityIds();
            ?>
            <h1 class="ui header">Show All Qualities</h1>
            <table class="ui compact celled definition table fixed single line">
                <thead>
                <tr>
                    <th style="width: 35px"></th>
                    <th>ID</th>
                    <th>Source</th>
                    <th style="width: 70px">#Reps</th>
                    <th style="width: 90px">#Frames</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($qualities->qualities as $quality) { ?>
                <tr>
                    <td class="collapsing">
                        <div class="ui fitted slider checkbox">
                            <input id="cB_<?php echo $quality->id ?>" type="checkbox" <?php if($quality->status != "FINISHED") { echo "disabled='true'"; }?>> <label></label>
                        </div>
                    </td>
                    <td>
                        <a href="ShowQuality.php?id=<?php echo $quality->id ?>"><?php echo $quality->id ?></a>
                    </td>
                    <td>
                        <?php echo filenameFromURL($quality->originalUrl) ?>
                    </td>
                    <td>
                        <?php echo count($quality->results) ?>
                    </td>
                    <td>
                        <?php echo $quality->numberOfFrames ?>
                    </td>
                </tr>
                <?php }?>
                </tbody>
                <tfoot class="full-width">
                    <tr>
                        <th></th>
                        <th colspan="4">
                            <div class="ui right floated small primary button" onclick="compare()">
                                Compare
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        <?php ?>
        </div>
    </body>
</html>