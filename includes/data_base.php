<?php 

function getConnexion(){

    $servername = 'db';
    $dbname = 'recipes';
    $user = 'recipes';
    $password = 'Nf6RQ1NKJ49nWZ7b0';
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4",$user,$password);

    return $dbco;

}


?>