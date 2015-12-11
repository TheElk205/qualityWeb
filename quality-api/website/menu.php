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

<div class="ui fixed inverted menu">
    <div class="ui container">
        <a href="#" class="header item">
            Video Quality
        </a>
        <a href="#" class="item">Home</a>
        <div class="ui simple dropdown item">
            Add Quality <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="AddSimpleQuality.php">Simple Quality</a>
                <a class="item" href="#">Link Item</a>
                <div class="divider"></div>
                <div class="header">Header Item</div>
                <div class="item">
                    <i class="dropdown icon"></i>
                    Sub Menu
                    <div class="menu">
                        <a class="item" href="#">Link Item</a>
                        <a class="item" href="#">Link Item</a>
                    </div>
                </div>
                <a class="item" href="#">Link Item</a>
            </div>
        </div>
        <div class="ui simple dropdown item">
            Show Quality <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="ShowQuality.php">Simple Quality</a>
            </div>
        </div>
    </div>
</div>
