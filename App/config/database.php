<?php
include_once('setup.php');
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->exec("SET CHARACTER SET utf8");
} catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
}
$query = file_get_contents('camagru.sql');
$array = explode(";\n", $query);
$b = true;
for ($i = 0; $i < count($array); $i++) {
    $str = $array[$i];
    if ($str != '') {
         $str .= ';';
         $b = $db->query($str);
    }
}
