<?php
require_once('init.php');
$auth = new Auth;

if(empty($auth->authGetUser())){
    header('Location: auth.php'); 
}
$charts = new Charts;
$cities = $charts->getCitiesPercent();
$visits = $charts->getVisitsByHours();

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Счетчик посещений</title>
        <script src="https://www.google.com/jsapi"></script>
        <link href="assets/style.css" rel="stylesheet" />
    </head>
    <body>
        <script>
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    <?=$visits?>
                ]);
                var options = {
                    title: 'Посещения по часам за сутки',
                    hAxis: {title: 'Визитов'},
                    vAxis: {title: 'Часы'}
                };
                var chart = new google.visualization.BarChart(document.getElementById('visits'));
                chart.draw(data, options);

                var cityData = google.visualization.arrayToDataTable([
                    <?=$cities?>
                ]);
                var cityOptions = {
                title: 'Города посетителей',
                is3D: true,
                };
                var chart = new google.visualization.PieChart(document.getElementById('cities'));
                chart.draw(cityData, cityOptions);
   
            }
        </script>
        <div id="logout" style="width: 700px; height: 20px;">
            <a href ="auth.php?action=logout">Выйти</a>
        </div>
        <div id="cities" style="width: 700px; height: 400px;"></div>
        <div id="visits" style="width: 700px; height: 400px;"></div>
    </body>
</html>
