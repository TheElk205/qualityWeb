<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 03:03
 */
?>
<!-- menu -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<!-- Site Properities -->
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

<div class="ui fixed inverted menu">
    <div class="ui container">
        <a href="#" class="header item">
            Video Quality
        </a>
        <a href="#" class="item">Home</a>
        <div class="ui simple dropdown item">
            Add
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="AddQuality.php">Add Quality</a>
                <a class="item" href="AddQualityTest.php">Add Quality Test</a>
                <a class="item" href="AddQualityFromBitcodin.php">From bitcodin</a>
            </div>
        </div>
        <div class="ui simple dropdown item">
            Show
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="ShowQuality.php">Show Quality</a>
                <a class="item" href="ShowQualityTest.php">Show Quality Test</a>
                <a class="item" href="ShowAllQualities.php">Show All Qualities</a>
                <a class="item" href="CompareQualities.php">Compare Qualities</a>
            </div>
        </div>
        <div class="ui simple dropdown item">
            Data
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="SaveData.php">Save</a>
                <a class="item" href="RestoreData.php">Restore</a>
            </div>
        </div>
    </div>
</div>
