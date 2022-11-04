<?php 

function getConnexion(){

    $servername = 'localhost';
    $dbname = 'recipes';
    $user = 'root';
    $password = '';
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4",$user,$password);

    return $dbco;

}


?>