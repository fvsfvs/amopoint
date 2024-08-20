<?php
require_once('config.php');
require_once('app/db.php');
$db = new DB;
$data = $_POST;
if(!empty($data['site'])){
    $params['agent'] = !empty($data['agent']) ? $data['agent'] : '';
    $params['city'] = !empty($data['city']) ? $data['city'] : '';
    $params['ip'] = !empty($data['ip']) ? $data['ip'] : '';
    $params['site'] = $data['site'];
    $sql = "INSERT INTO visits (`site`, `ip`, `city`, `agent`) 
        VALUES (:site, :ip, :city, :agent)";
    $db->query($sql, $params);
}