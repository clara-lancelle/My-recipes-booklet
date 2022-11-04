<?php 

function getConnexion(){

<<<<<<< HEAD:data_base.php
    $servername = 'localhost';
    $dbname = 'recipes';
    $user = 'root';
    $password = '';
=======
    $servername = 'db';
    $dbname = 'recipes';
    $user = 'recipes';
    $password = 'Nf6RQ1NKJ49nWZ7b0';
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355:includes/data_base.php
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4",$user,$password);

    return $dbco;

}


?>