<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 02:45
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


        <!-- Is called when new Quality is created -->
        <script>
            $(document)
                .ready(function() {
                    $('.ui.form')
                        .form({
                            fields: {
                                email: {
                                    identifier  : 'email',
                                    rules: [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter your e-mail'
                                        },
                                        {
                                            type   : 'email',
                                            prompt : 'Please enter a valid e-mail'
                                        }
                                    ]
                                },
                                password: {
                                    identifier  : 'password',
                                    rules: [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter your password'
                                        },
                                        {
                                            type   : 'length[6]',
                                            prompt : 'Your password must be at least 6 characters'
                                        }
                                    ]
                                }
                            }
                        })
                    ;
                })
            ;
        </script>

        <meta charset="UTF-8">
        <title>Add new Simple Quality</title>
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
                    <br>
                    <button class="ui button" style="width: 100%">Create Quality</button>
                </div>
            </form>
        </div>
        </body>
</html>
