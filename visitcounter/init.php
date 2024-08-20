<?php
session_start();
include_once('config.php');
include_once('app/auth.php');
include_once('app/charts.php');
include_once('app/db.php');
$db = new DB;