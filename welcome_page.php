<<<<<<< HEAD
<?php
session_start();
include "configuration.php";

include "includes/function_welcome.php";

if (!empty($_SESSION['id']) && ($_SESSION['id'] !== null)) {
    header("location:" . BASE_URL . "all_recipes.php");
    die();

} else {

    $return = get_recent_recipes();
=======
<?php 
session_start();
   
include "includes/function_welcome.php";

if(!empty($_SESSION['id']) && ($_SESSION['id'] !== null)){
    header("location: all_recipes.php");
die();
    
}else{

$return = get_recent_recipes();
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

?>

<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">

<head>

    <?php include "includes/include_meta_link.php"; ?>

    <title>Mon carnet de recettes - Bienvenue </title>
=======
<html lang="en" >
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mon carnet de recettes - Bienvenue </title>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

</head>

<body>
    <header>
        <?php $current_page = "welcome"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller wel small-top">
        <section class="bloc bloc--welcome">

<<<<<<< HEAD
            <h1 class="bloc__title"> Mon Carnet de Recettes </h1>
            <h2 class="header__title"> Un carnet en ligne pour vos <em>recettes de cuisine préférées</em>, à remplir de
                toutes
                vos plus belles réussites et à partager ! </h2>

            <p class="bg--white">
                Plus besoin de noter vos recettes sur des feuilles de papiers perdues dans vos tiroirs,<br>
                Toutes vos recettes seront illustrées, ordonnées et faciles d’accès. <br><br>

                Vous pourrez, dans votre carnet, enregistrer toutes vos recettes de cuisine, les modifier et les
                supprimer. <br>

                Elles seront automatiquement ajoutées dans une page spécifique de notre site visible par la communautée.
                <br><br><br>

                Vous pourrez ainsi les partager avec vos proches et d’autres cordons-bleus ! <br>
            </p>
            <div class="divider"></div>
            <h4 class="header__subtitle"> Les dernières recettes de la communautée : </h4>
            <?php
    if (!isset($return['error'])) { ?>
            <div class="card_group">
                <?php
        $recipes = $return['recipes'];
        $i = 0;
        foreach ($recipes as $array => $recipe) {
                ?>
                <div class="card card--small card--xsmall">
                    <div class="card__header card__header--xsmall">
                        <?php
            echo '<img src="'.BASE_URL.'/Pictures/'.$recipe['name'].'" 
                            class="card__img--max" alt="image de ma recette de cuisine" >';
                        ?>
                    </div>

                    <div class="card__body card__body--xsmall">
                        <?php
            $last = substr($recipe['last_name'], 0, 1);

            echo '<h5 class="card__body__title">' . ucfirst($recipe['recipe_title']) . '</h5>
                        <p class="list-group-item card__body__p"> <i class="bi bi-vector-pen"></i> Auteur : ' . $recipe['first_name'] . '
                            ' . $last . '.</p>';
=======
        <h2 class="bloc__title" > My Recipe Booklet </h2>
        <h3 class="header__title"> Un carnet en ligne pour vos recettes de cuisine préférées, à remplir de toutes vos plus belles réussites et à partager ! </h3>

        <p class="bg--white">
            Plus besoin de noter vos recettes sur des feuilles de papiers perdues dans vos tiroirs,<br>
            Toutes vos recettes seront illustrées, ordonnées et faciles d’accès. <br><br>

            Vous pourrez, dans votre carnet, enregistrer toutes vos recettes de cuisine, les modifier et les supprimer. <br>

            Elles seront automatiquement ajoutées dans une page spécifique de notre site visible par la communautée. <br><br><br>

            Vous pourrez ainsi les partager avec vos proches et d’autres cordons-bleus ! <br>
        </p>
        <div class="divider"></div>
        <h4 class="header__subtitle"> Les dernières recettes de la communautée : </h4>
        <?php
            if(!isset($return['error'])){  ?> 
            <div class="card_group"> <?php
                    $recipes = $return['recipes'];
                    $i = 0;
                    foreach($recipes as $array => $recipe){
                ?>
                <div class="card card--small">
                    <div class="card__header">
                        <?php 
                        echo '<img src="/Pictures/'.$recipe['name'].'" 
                            class="card__img--max" alt="image de ma recette de cuisine" >';
                        ?> 
                    </div>

                    <div class="card__body card__body--small">
                        <?php
                        $last = substr($recipe['last_name'],0,1);

                            echo '<h5 class="card__body__title">'.ucfirst($recipe['recipe_title']).'</h5>
                            <p class="list-group-item "> <i class="bi bi-vector-pen"></i> Auteur : '.$recipe['first_name'].'  '.$last.'.</p>';
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                        ?>

                    </div>
                </div>
<<<<<<< HEAD
                <?php } ?>
                <?php } ?>
            </div>
        </section>
    </main>
    <?php } ?>
    <?php
    include "includes/footer.php";
    include "includes/include_script.php";
    ?>
</body>

</html>
=======
                <?php } ?> 
            <?php } ?>
            </div>
        </section>
    </main>
<?php } ?> 
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/index.js"></script>
</body>
</html>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
