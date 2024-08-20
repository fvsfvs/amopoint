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

        $query = "SELECT HOUR(`time`) as h, COUNT(*) AS num FROM `visits` GROUP BY h ORDER BY num DESC";
        $hours = $this->db->select($query);

        $visitsStr = "['Часы', 'Посещения']";
        $existingHours = array_column($hours, 'h');
        for($i = 0; $i < 24; $i++){
            $key = (array_search(strval($i), $existingHours));
            if($key !== false){
                $visitsStr .= ",[$i, {$hours[$key]['num']}]";
            }
            else {
                $visitsStr .= ",[$i, 0]";
            }
        }
        return $visitsStr;
    }

}