<!doctype html>
<html lang ="pl">
<head>
    <meta charset="utf-8"/>
    <title>Biblioteka I Lo im. ONZ w Biłgoraju</title>
    <link rel="stylesheet" href="../main.css" type="text/css"/>

    <?php
    $created = "<br/>Nic się nie dzieje.";
    if (isset($_POST['create']))
    {
        $date = $_POST['event_date'];
        $day = $date[8].$date[9];
        $dayNoZero = "";                //Day number without zero on first place
        if ($day[0]==0){                // Declaration of $dayNoZero
            $dayNoZero=$day[1];
        }
        else{
            $dayNoZero = $day;
        }
        $monthN = $date[5].$date[6]; //Month number
        $year = $date[0].$date[1].$date[2].$date[3];
        switch ($monthN){
            case "01":
                $month = "stycznia";
                break;
            case "02":
                $month = "lutego";
                break;
            case "03":
                $month = "marca";
                break;
            case "04":
                $month = "kwietnia";
                break;
            case "05":
                $month = "maja";
                break;
            case "06":
                $month = "czerwca";
                break;
            case "07":
                $month = "lipca";
                break;
            case "08":
                $month = "sierpnia";
                break;
            case "09":
                $month = "września";
                break;
            case "10":
                $month = "października";
                break;
            case "11":
                $month = "listopada";
                break;
            case "12":
                $month = "grudnia";
                break;
        }
        $eventDate = $dayNoZero." ".$month." ".$year;
        $title = $_POST['title'];
        $article = $_POST['article'];
        $image = $_FILES['img'];
        $eventDateFormatted = $year."_".$monthN."_".$day;    //date formatted to yyyy_mm_dd which will be used for article's images and to name article's own site
        $imgName = $eventDateFormatted.".jpg";              //generating img name

        $target_dir="images/";
        $target_file = $target_dir.$imgName;
        $uploadOK = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        //Check if file is an image not fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check != false){
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOK = 1;
        }
        else{
            echo "File is not an image.";
            $uploadOK = 0;
        }
        //check if file alredy exists
        if (file_exists($target_file)){
            $imgName = $eventDateFormatted."(2).jpg";
            echo "sorry, file alredy exists. Name changed to $imgName";
            $target_file = $target_dir.$imgName;
            $uploadOK = 1;
            if (file_exists($target_file)){
                echo "File $imgName alredy exists too, ask Mateusz Małek what to do in this case.";
                $uploadOK = 0;
            }
        }
        //check file size
        if ($_FILES["img"]["size"]>500000){
            echo "sorry, your file is too large";
            $uploadOK = 0;
        }
        //allow certain file formats
        if ($imageFileType != "jpg"){
            echo "Sorry, only jpg files are allowed";
            $uploadOK = 0;
        }
        //check if $uploadOK is set to 0 by an error
        if ($uploadOK==0){
            echo "Sorry, your file was not uploaded.";
        }
        //if everything is ok, try to upload file
        else{
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)){
                echo "The file ".basename($_FILES["img"]["name"])." has been uploaded as $imgName.";
                $articleToAdd ="
            <article><h1>$eventDate</h1><h2>$title</h2> <content><img src='/news/images/$imgName'/>$article</content></article>
            
            ";
                $newArticleName = $eventDateFormatted."txt";
                if (file_exists($newArticleName)){
                    $newArticleName = $eventDateFormatted."(2).txt";
                }
                $article_file = fopen($eventDateFormatted.".txt", "c");
                fwrite($article_file, $articleToAdd);
                fclose($article_file);

                $created = "created";
            }else{
                echo"Sorry, there was an error uploading your file";
                $created = "not created";
            }
        }
    }

    else{
    }
    print $created;
    ?>

</head>
<body>
<div id="wrapper">

    <?php
//    require 'site_layout/header.html';
//    require 'site_layout/menu.html';
    ?>
<!--    <div id="left_side_box">

    </div>-->
    <?php/*
    if (isset($_POST['create'])){
        print $_POST['event_date']." \n".$year."_".$month."_".$day." \n".$articleToAdd;
    }*/
    ?>


    <content id="main_box">

        <form accept-charset="UTF-8" action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <label>Data wydarzenia:<br/>
                <input required="required" type="date" pattern="yyyy_mm_dd" name="event_date" autofocus="autofocus"><br/>
            </label>
            <label>
                Tytuł:<br/>
                <input type="text" required="required" name="title" size="150"></input><br/>
            </label>
            <label>Artykuł:<br/>
                <textarea required="required" name="article" rows="10" cols="153"></textarea> <br/>
            </label>
            <label>Obrazek:<br/>
                <input required="required" type="file" name="img"><br/>
            </label>
            <button type="submit" name="create" style="margin-top:5px;">Utwórz</button>
        </form>



    </content>
    <?php
//    include 'site_layout/side_news.html';
    require '../site_layout/footer.html';
    ?>

</div>
</body>