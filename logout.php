<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en" style="background-color:rgb(233, 233, 233);"> 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_logout.css">

  <title>Mes recettes - Déconnexion </title>

</head>

<body>
    <header>
        <?php $current_page = "out"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <div class="container-fluid justify-content-center m-auto text-center py-5">

        <?php
            if(!isset($_POST['logout'])){

        ?>

        <h6>Voulez-vous vous déconnecter du carnet de recettes ?</h6>
            <form action="#" method="post" enctype="multipart/form-data">
                <button class="logout my-5" type="submit" name="logout" value="true">Me deconnecter</button>
            </form>

        <?php
            }else{
                session_destroy();
                echo 'vous avez été déconnecté(e) avec succès !';
                header("location: login.php");
                die(); 
            } 
        ?>
    
    </div>
    <?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>