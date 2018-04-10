<!doctype html>
<html lang ="pl">
<head>
    <meta charset="utf-8"/>
    <title>Biblioteka I Lo im. ONZ w Biłgoraju</title>
    <link rel="stylesheet" href="main.css" type="text/css"/>
    <?php
    function create_array(){
        $articles[0] = "";
        $i=0;
        foreach (glob("news/*.txt") as $filename) {
            $articles[$i] = $filename;
            $i++;
            rsort($articles);
        }
        return $articles;
    }
    function article_formating(){
                $articles = create_array();
                foreach ($articles as $number => $article) {
                    print $number + 1 . "." . ' ' . $article . "<br/>";
                    $handle = fopen($article, 'r');
                    $string = fread($handle, filesize($article));
                    fclose($handle);
                    $delimeter = "\n";
                    $strings = explode($delimeter, $string);
                    $last_string = count($strings)-1;
                    for ($i=0;$i<$last_string;$i++){
                        ltrim($strings[$i], " ");
                        rtrim($strings[$i], " ");
                    }
                    rtrim($strings[$last_string]);
                    echo "\"$strings[$last_string]\"";
                    $article = "<article><h1>$strings[0]</h1><h2>$strings[1]</h2><content><img src='news/images/$strings[$last_string].jpg'><p>$strings[2]<a style=\"color:grey;font-size:100%;\"href=\"\\news\\news_sites\\$strings[$last_string].php\">...więcej</a></p></content></article>";
                    print($article);
                }
    }
    ?>
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
        article_formating();
        ?>


    </content>
    <?php
    include 'site_layout/side_news.html';
    require 'site_layout/footer.html';
    ?>

</div>
</body>