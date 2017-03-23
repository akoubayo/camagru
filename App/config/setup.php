<?php
include_once('database.php');
$dns = explode(';',$DB_DSN);
try {
    $db = new PDO($dns[0], $DB_USER, $DB_PASSWORD);
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