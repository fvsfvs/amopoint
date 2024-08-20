<?php
require_once('handler.php');
//include_once('config.php');
$text = '';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Подсчет цифр в строках файла</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>
        <div id = "container">
            <form method = "post" enctype = "multipart/form-data">
                <input type="file" name = "file" accept="text/plain">
                <input type="submit" value = "загрузить">
            </form>
            <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $fileHandler = new Handler;
                $loadResponse = $fileHandler->fileLoad();
                if(empty($loadResponse['error'])){
                    $text = $fileHandler->numbersInFile();
                    $circleColor = "green";
                }
                else {
                    $circleColor = "red"; 
                }
            }
            ?>
            <div id = "loadResponse">
                <?php if(!empty($loadResponse)):?>
                    <div id = "circle" style = "background: <?=$circleColor?>;">
                    </div>
                    <div id = "response">
                        <?php $circleColor == "red" ? $response = $loadResponse['error'] : $response = $loadResponse['success'];?>
                        <?=$response?>
                    </div>
                <?php endif?>
            </div>
            <div id = "text">
                <?=$text?>
            </div>
        </div>
    </body>
</html>


