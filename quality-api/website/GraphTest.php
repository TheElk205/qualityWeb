<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 04.01.2016
 * Time: 19:41
 */
include_once  '..\autoload.php';
use \quality\QualityApi as QualityApi;
$api = new QualityApi();
//echo $api->getDCJSDataWithId("de730e241f83d8c2112ac6119a585ed1932707ab");
//var_dump($api->getQualityWithId("de730e241f83d8c2112ac6119a585ed1932707ab")->psnrFrames->results[0]->results);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- menu -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properities -->
    <title>Chart example</title>

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/dropdown.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/icon.css">

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/label.css">

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/input.css">

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/accordion.css">
    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/accordion.js">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.12/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crossfilter/1.3.12/crossfilter.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css">

    <style type="text/css">
        body {
            background-color: #FFFFFF;
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

    <script>
        $( document ).ready(function() {
            var hitslineChart  = dc.compositeChart("#chart-line-hitsperday");

            var data = <?php $api = new QualityApi();
                echo $api->getDCJSDataWithId("de730e241f83d8c2112ac6119a585ed1932707ab");
                ?>;
            /*var data =
                [
                {frame: 0, b4000: 43.34, b8000: 50.6},
                {frame: 1, b4000: 45.34, b8000: 51.6},
                {frame: 2, b4000: 42.34, b8000: 49.6},
                {frame: 3, b4000: 46.34, b8000: 52.6},
                {frame: 4, b4000: 41.34, b8000: 48.6},
                {frame: 5, b4000: 47.34, b8000: 53.6},
                {frame: 6, b4000: 40.34, b8000: 47.6},
                {frame: 7, b4000: 43.34, b8000: 50.6}
            ];*/
            var ndx = crossfilter(data);
            //var parseDate = d3.time.format("%m/%d/%Y").parse;
            data.forEach(function(d) {
                /*d.date = parseDate(d.date);
                d.total= d.http_404+d.http_200+d.http_302;
                d.Year=d.date.getFullYear();*/
            });

            var dateDim = ndx.dimension(function(d) {return d.frame;});
            var hits = dateDim.group().reduceSum(function(d) {return d.total;});
            var minDate = dateDim.bottom(1)[0].frame;
            var maxDate = dateDim.top(1)[0].frame;

            var b4000=dateDim.group().reduceSum(function(d) {return d.b0;});
            var b8000=dateDim.group().reduceSum(function(d) {return d.b1;});

            hitslineChart
                .width(500).height(200)
                .dimension(dateDim)
                .x(d3.scale.linear()
                    .domain([0,729]))
                .compose([
                    dc.lineChart(hitslineChart).group(b4000,"4000"),
                    dc.lineChart(hitslineChart).group(b8000,"8000")
                ])
                .brushOn(true)
                .yAxisLabel("PSNR");

            dc.renderAll();
        });
    </script>

    <meta charset="UTF-8">
    <title>Add new Simple Quality</title>
</head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <div id="chart-ring-year"></div>
            <div id="chart-line-hitsperday"></div>
        </div>
    </body>
</html>