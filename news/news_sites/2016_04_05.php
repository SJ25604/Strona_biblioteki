<!doctype html>
<html lang ="pl">
<head>
    <meta charset="utf-8"/>
    <title>Biblioteka I Lo im. ONZ w Biłgoraju</title>
    <link rel="stylesheet" href="main.css" type="text/css"/>
</head>
<body>
<div id="wrapper">

    <?php
    require 'site_layout/header.html';
    require 'site_layout/menu.html';
    ?>
<!--    <div id="left_side_box">

    </div>-->

    <content id="main_box">

    <?php
    try{
        foreach (glob("news/*.txt") as $filename){
            include $filename;
        }
    }catch(Exception $e){
        echo 'błąd: ';
    }

    ?>


    </content>
    <?php
    include 'site_layout/side_news.html';
    require 'site_layout/footer.html';
    ?>

</div>
</body>