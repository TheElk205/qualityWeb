<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 10:58
 */

require_once '../autoload.php';

use quality\QualityApi as QualityApi;

$quality = new QualityApi();

?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="../styles/main.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../charts/simpleGoogleBarChart.js"></script>
        <script src="//bitmovin-a.akamaihd.net/bitdash/latest/bitdash.min.js"></script>

        <!-- Loader-->
        <link rel="stylesheet" href="../../UI-Loader-master/loader.css">

        <!-- Accordions -->
        <script>
            $(function() {
                $( "#accordion_representations" ).accordion({
                    collapsible: true
                });
            });
            $(function() {
                $( "#accordion_player" ).accordion({
                    collapsible: true
                });
            });
            $(function() {
                $( "#accordion_middleValues" ).accordion({
                    collapsible: true,
                    heightStyle: "content"
                });
            });
        </script>
        <!-- Graphs Middle values -->
        <script>
            google.load('visualization', '1', {packages: ['corechart', 'bar']});
            google.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                <?php
                if (isset($_GET['id'])) {
                    $quality = $quality->getQualityWithId($_GET["id"]);
                    if ($quality->status == "FINISHED") {
                        $psnrDataContent = "[['', 'PSNR Values'],";
                        $ssimDataContent = "[['', 'SSIM Values'],";

                        if ($quality->results != null) {
                            foreach ($quality->results as $res) {
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
        <div id="website">

            <form action="GetQualityInfo.php" method="get">
                Quality ID:
                <select name="id" >
                    <?php foreach($quality->getQualityIds()->getAllIds() as $id) {
                        echo "<option value='" . $id . "'>" . $id . "</option>";
                    }?>
                </select>
                <br>
                <input class="myButton" type="submit" value="Get Info">
            </form>
            <br>
            <div class="datagrid">
                <?php
                if (isset($_GET["id"])) {
                    ?>
                    <table>
                        <tbody>
                            <tr>
                                <td>Informationen zu ID:</td>
                                <td><?php echo $quality->id ?></td>
                            </tr>
                            <tr class="alt">
                                <td>Status:</td>
                                <td><?php echo $quality->status ?></td>
                            </tr>
                            <tr>
                                <td>Time needed:</td>
                                <td><?php echo QualityApi::getFormattedtiemString($quality->timeNeeded) . "  " . $quality->timeNeeded?></td>
                            </tr>
                            <tr class="alt">
                                <td>Number of threads:</td>
                                <td><?php echo $quality->numberOfThreads ?></td>
                            </tr>
                            <tr>
                                <td>Time per Thread:</td>
                                <td><?php echo QualityApi::getFormattedtiemString($quality->timeNeeded/$quality->numberOfThreads) ?></td>
                            </tr>
                            <tr class="alt">
                                <td>Number of frames:</td>
                                <td><?php echo $quality->numberOfFrames ?></td>
                            </tr>
                            <tr>
                                <td>Original Video:</td>
                                <td><a href="<?php echo $quality->originalUrl ?>"><?php echo $quality->originalUrl ?></a></td>
                            </tr>
                            <tr class="alt">
                                <td>MPD-File:</td>
                                <td><a href="<?php echo $quality->mpdUrl ?>"><?php echo $quality->mpdUrl ?></a></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
                <br>
                <div id='accordion_representations'>
                    <h3>Representations:</h3>
                    <div class="datagrid">
                        <?php if(isset($_GET['id']) && $quality->results != null) { ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Attributes</th>
                                        <th colspan="<?php echo count($quality->results) ?>" style="text-align: center">Representations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Bitrate:</td>
                                        <?php foreach($quality->results as $res) {
                                            echo "<td>" . $res->bitrate . "</td>";
                                        }?>
                                    </tr>
                                    <tr class="alt">
                                        <td>Time Needed:</td>
                                        <?php foreach($quality->results as $res) {
                                            echo "<td>" . $res->timeNeeded . "</td>";
                                        }?>
                                    </tr>
                                    <tr>
                                        <td>PSNR:</td>
                                        <?php foreach($quality->results as $res) {
                                            echo "<td>" . $res->psnr . "</td>";
                                        }?>
                                    </tr>
                                    <tr class="alt">
                                        <td>SSIM:</td>
                                        <?php foreach($quality->results as $res) {
                                            echo "<td>" . $res->ssim . "</td>";
                                        }?>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
                <div id='accordion_middleValues'>
                    <h3>Middle values:</h3>
                    <div>
                        <div class="ui segment">
                            <div class="ui active dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>
                            <p></p>
                        </div>
                        <div id='chart_psnr_div' style=''></div>
                        <div id='chart_ssim_div'></div>
                    </div>
                </div>
                <div id="accordion_player">
                    <h3>Video:</h3>
                    <div id="player" ></div>
                </div>
                <script type="text/javascript">
                    var conf = {
                        key: "<?php echo $quality->getPlayerkey()?>",
                        source:    {
                            dash: "<?php echo $quality->getQualityWithId($_GET["id"])->mpdUrl?>"
                        }
                    };
                    var player = bitdash('player');

                    player.setup(conf).then(function(value) {
                        // Success
                    }, function(reason) {
                        // Error!
                    });
                </script>
        </div>
    </body>
</html>