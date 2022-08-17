<?php 
session_start();
if(isset($_POST['logout'])){
    session_destroy();
    header("location: index.php");
    die(); 
} 
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Déconnexion </title>

</head>

<body>
    <header>
        <?php $current_page = "out"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller grey">

        <?php
            if(!isset($_POST['logout'])){

        ?>

        <section class="bloc text-center bloc--pad" >
            <h6 class="pad">Voulez-vous vous déconnecter du carnet de recettes ?</h6>
                <form action="#" method="post" enctype="multipart/form-data">
                    <button class="btn btn--logout" type="submit" name="logout" value="true">Me déconnecter</button>
                </form>

            <?php
                }?>
        </section>
    </main>
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/index.js"></script>
</body>
</html>