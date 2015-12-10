<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 17:22
 */
include_once "../QualityApi.php";
include_once "../QualityTestInfo.php";

use quality\QualityApi as QualityApi;
use quality\QualityTestInfo as QualityTestInfo;

$quality = new QualityApi();

$data = array();
$count = array();
$midValues = array();

?>
<html>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../charts/simpleGoogleBarChart.js"></script>

        <script>
            google.load('visualization', '1', {packages: ['corechart', 'bar']});
            google.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                <?php
                    if(isset($_GET['id'])) {
                        $answer = $quality->getQualityTestWithId($_GET['id']);
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
                    }
                ?>
                var data = <?php echo $dataString ?>;
                drawSimpleBarchart(data, 'Time for Number of Threads', '#Threads', 'seconds', 'chart_div');
            }
        </script>
    </head>
    <body>
        <div>
            <form action="GetQualityTestInfo.php" method="get">
                Quality ID:
                <input type="number" name="id" value="<?php if(isset($_GET['id'])) { echo $_GET['id']; } else { echo "1"; } ?>">
                <br>
                <input type="submit" value="Get Info">
            </form>
            <?php
            if(isset($_GET['id'])) {
                echo "Middle values over " . array_values($count)[0] . " calculations:<br>";
                echo "<div id=\"chart_div\"></div>";
                var_dump($answer);
            }
            ?>


        </div>
    </body>
</html>