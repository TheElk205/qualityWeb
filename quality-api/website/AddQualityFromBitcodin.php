<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 14.12.2015
 * Time: 18:03
 */
include "../../vendor/autoload.php";

use bitcodin\Bitcodin;
use bitcodin\EncodingProfile;
use bitcodin\Job;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- menu -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properities -->
    <title>Fixed Menu Example - Semantic</title>

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

    <link rel="stylesheet" type="text/css" href="../../Semantic-UI-master/dist/components/table.css">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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

    <!-- pagination of table -->
    <script>
        $(document).ready(function(){
            $('#data').after('<a class="icon item" id="leftArrow">');
            var rowsShown = 5;
            var rowsTotal = $('#data tbody tr').length;
            var numPages = rowsTotal/rowsShown;
            //$('#nav').append('<a class="icon item"> <i class="left chevron icon"></i> </a>');
            for(i = 0;i < numPages;i++) {
                var pageNum = i + 1;
                $('#nav').append('<a href="#" class="item" rel="'+i+'">'+pageNum+'</a> ');
            }
            //$('#nav').append('<a class="icon item"> <i class="right chevron icon"></i> </a>');
            $('#data tbody tr').hide();
            $('#data tbody tr').slice(0, rowsShown).show();
            $('#nav a:first').addClass('active');
            $('#nav a').bind('click', function(){

                $('#nav a').removeClass('active');
                $(this).addClass('active');
                var currPage = $(this).attr('rel');
                var startItem = currPage * rowsShown;
                var endItem = startItem + rowsShown;
                $('#data tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
                css('display','table-row').animate({opacity:1}, 300);
            });
        });
    </script>

    <meta charset="UTF-8">
    <title>Add new Simple Quality</title>
</head>
    <body>
        <?php include 'menu.php'?>
        <div class="ui main text container">
            <form class="ui large form" name="createQuality" action="AddQualityFromBitcodin.php">
                <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                    <a class="ui label" style="width: 135px">Api Key</a>
                    <input type="text" name="apiKey" required="true" placeholder="API Key" <?php if(isset($_GET['apiKey'])) { echo "value='" . $_GET['apiKey'] . "'";} ?> >
                </div>
                <button class="ui button" style="width: 100%">Set API Key</button>

            </form>
            <?php if(isset($_GET['apiKey'])) {
                Bitcodin::setApiToken($_GET['apiKey']);
	            $jobs = Job::getList();?>
                <table id='data' class="ui right aligned celled table">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Encoding ID</th>
                            <th>Input ID</th>
                            <th>Calculate Quality</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($jobs->jobs as $job) {
                            if($job->status == "Finished") {?>
                                <tr>
                                    <td><img src="<?php echo $job->input->thumbnailUrl ?>" style="width: 114px;height: 64px;"></td>
                                    <td><?php echo $job->jobId ?></td><td><?php echo $job->input->inputId ?></td>
                                    <td>
                                        <form name='f1' method='get' action="AddQuality.php">
                                            <input name='originalUrl' type='hidden' id='newOrigUrl' value=<?php echo $job->input->url ?>>
                                            <input name='mpdUrl' type='hidden' id='newMpdUrl' value=<?php echo json_decode(json_encode($job->manifestUrls),true)['mpdUrl'] ?>>
                                            <!--<input type='hidden' name="apiKey" value="<?php echo $_GET['apiKey'] ?>">-->
                                            <button class="ui button" name='setUrls' style="width: 100%;">Get Urls</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }} ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4">
                            <div class="ui right floated pagination menu" id="nav">
                            </div>
                        </th>
                    </tr></tfoot>
                </table>
            <?php } ?>
        </div>
    </body>
</html>
