<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 20:31
 */

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

    <meta charset="UTF-8">
    <title>Add new Quality Test</title>
</head>
<body>
<?php include 'menu.php'?>
<div class="ui main text container">
    <form class="ui large form" name="createQuality" action="AddQualityController.php">
        <div class="ui stacked segment">
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                <a class="ui label" style="width: 135px">Original Video</a>
                <input type="text" name="originalUrl" required="true" placeholder="original.mp4" <?php if(isset($_GET['originalUrl'])) { echo "value='" . $_GET['originalUrl'] . "'";} ?> >
            </div>
            <br>
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%"">
                <a class="ui label" style="width: 135px">Mpd File</a>
                <input type="text" name="mpdUrl" required="true" placeholder="representations.mpd" <?php if(isset($_GET['mpdUrl'])) { echo "value='" . $_GET['mpdUrl'] . "'";} ?>>
            </div>
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                <a class="ui label" style="width: 135px">#Threads Min</a>
                <input type="text" name="originalUrl" required="true" value="<?php if(isset($_GET['threadCountMin'])) { echo $_GET['threadCountMin'];} else {echo 1;} ?>" >
            </div>
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                <a class="ui label" style="width: 135px">#Threads Max</a>
                <input type="text" name="originalUrl" required="true" value="<?php if(isset($_GET['threadCountMax'])) { echo $_GET['threadCountMax'];} else {echo 1;}?>" >
            </div>
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                <a class="ui label" style="width: 135px">Step Size</a>
                <input type="text" name="originalUrl" required="true"  value="<?php if(isset($_GET['threadStepSize'])) { echo $_GET['threadStepSize'];} else {echo 1;}?>" >
            </div>
            <div class="ui labeled input" style="padding-bottom: 2px;width: 100%">
                <a class="ui label" style="width: 135px">#Repetitions</a>
                <input type="text" name="originalUrl" required="true" value="<?php if(isset($_GET['threadRepetitons'])) { echo $_GET['threadRepetitons'];} else {echo 1;}?>" >
            </div>
            <button class="ui button" style="width: 100%">Create Quality Test</button>
            <!-- Information -->
            <div class="ui styled fluid accordion" style="margin-bottom: 16px;margin-top: 16px;" aria-expanded="false"; aria-selected="false">
                <div class="title" aria-expanded="false"; aria-selected="false">
                    <i class="dropdown icon"></i>
                    Parameter Information
                </div>
                <div class="content" style="display: inline">
                    <div>
                        <table class="ui definition celled right aligned table">
                            <tbody>
                                <tr>
                                    <td class="right aligned">Original Video</td>
                                    <td>URL to the original video</td>
                                </tr>
                                <tr>
                                    <td class="right aligned">Mpd File</td>
                                    <td>URl to the mpd file describing the representations</td>
                                </tr>
                                <tr>
                                    <td class="right aligned">#Threads Min</td>
                                    <td>Minimum number of threads to compute with</td>
                                </tr>
                                <tr>
                                    <td class="right aligned">#Threads Max</td>
                                    <td>Maximum number of threads to compute with. Even if this value can not be reached becaus eof the stepsize it is executed.</td>
                                </tr>
                                <tr>
                                    <td class="right  aligned">Stepsize</td>
                                    <td>Number of Threads to skip during iteration</td>
                                </tr>
                                <tr>
                                    <td class="right aligned">#Repetitions</td>
                                    <td>Defines how often each thread count will be executed</td>
                                </tr>
                                <tr>
                                    <td class="right aligned">Example:</td>
                                    <td>With: #Threads Min=1; #Threads Max=6; Step Size=2; #Repetitions=2;<br>
                                    Execution (#Threads): 1, 1, 3, 3, 5, 5, 6, 6</td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>

</div>
</form>
</div>
</body>
</html>
