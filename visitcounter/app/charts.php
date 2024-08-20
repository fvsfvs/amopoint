<?php

Class Charts
{
    private $db;
    
    /**
     * __construct
     *
     * @return void
     */
    function __construct(){
        global $db;
        $this->db = $db;
    }
    
    /**
     * getCitiesPercent
     *
     * @return string
     */
    function getCitiesPercent() : string {

        $citiesQuery = "SELECT city, COUNT(*) AS num FROM `visits` GROUP BY city ORDER BY num DESC";
        $cities = $this->db->select($citiesQuery);
        $countQuery = "SELECT COUNT(*) AS num FROM `visits`";
        $count = $this->db->select($countQuery);
        $citiesNum = $count[0]['num'];

        $chartStr = "['Город', 'Посещения']";
        foreach ($cities as $city){
            $percent = $city['num'] / $citiesNum * 100;
            $chartStr .= ",['{$city['city']}', $percent]";
        }
        return $chartStr;
    }
    
    /**
     * getVisitsByHours
     *
     * @return string
     */
    function getVisitsByHours() : string {

        $fromTime = strtotime('-1 day');
        $from = date('Y-m-d H:i:s', $fromTime);

        $sql = "SELECT * FROM `visits` WHERE `time` > :from ORDER BY `time` DESC";
        $rows = $this->db->select($sql, ['from' => $from]);
        $visitsByHours = [];

        foreach ($rows as $row){
            $hour = strval(intval(substr($row['time'], 11, 2)));
            if(!isset($visitsByHours[$hour]) || !in_array($row['ip'], $visitsByHours[$hour])){
                $visitsByHours[$hour][] = $row['ip'];
            }
        }

        $visitsStr = "['Часы', 'Посещения']";
        for($i = 0; $i < 24; $i++){
            if(array_key_exists(strval($i), $visitsByHours)){
                $num = count($visitsByHours[strval($i)]);
                $visitsStr .= ",[$i, $num]";
            }
            else {
                $visitsStr .= ",[$i, 0]";
            }
        }
        return $visitsStr;
    }

}
