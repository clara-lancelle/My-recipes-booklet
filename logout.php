<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en" style="background-color:rgb(233, 233, 233);"> 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Déconnexion </title>

</head>

<body>
    <header>
        <?php $current_page = "out"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller">

        <?php
            if(!isset($_POST['logout'])){

        ?>

        <section class="bloc text-center" >
            <h6>Voulez-vous vous déconnecter du carnet de recettes ?</h6>
                <form action="#" method="post" enctype="multipart/form-data">
                    <button class="logout btn" type="submit" name="logout" value="true">Me deconnecter</button>
                </form>

            <?php
                }else{
                    session_destroy();
                    echo 'vous avez été déconnecté(e) avec succès !';
                    header("location: index.php");
                    die(); 
                } 
            ?>
        </section>
    </main>
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="http://localhost/TD_RECIPES/js/index.js"></script>
</body>
</html>