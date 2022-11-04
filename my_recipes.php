<?php

session_start();
include "configuration.php";

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    if(isset($_COOKIE)){
        setcookie("PHPSESSID","",time()-3600,"/"); 
    }
   header("location:".BASE_URL."/index.php");
   exit();
}
if(isset($_GET['page']) && !empty($_GET['page'])){
    $current_page_nb = (int) strip_tags($_GET['page']);

}else{
    $current_page_nb = 1;
}

include "includes/function_my_recipes.php";

    $user_id = $_SESSION['id'];
<<<<<<< HEAD

//filter
    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
=======
    if(isset($_POST['filter'])){
        $filter = $_POST['filter'];
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
    }else{
        $filter_tab['0']['empty'] = 'none';
        $filter = $filter_tab['0'];
    }
<<<<<<< HEAD
//sort
    if(isset($_GET['sort'])){
        $sort = $_GET['sort'];
    }else{
        $sort_tab['0']['desc'] = 'desc';
        $sort =  $sort_tab['0'];
    }

    $return = getRecipes($user_id, $current_page_nb, $filter, $sort); 
=======
    $return = getRecipes($user_id, $current_page_nb, $filter); 
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

    if(!isset($return['error'])){
        $pages = $return['pages_nb'];
        $first_recipe = $return['first'];
        $recipes = $return['recipes'];
    }
    
?>
<!DOCTYPE html>
<html lang="en"> 
<head >
<<<<<<< HEAD

    <?php include "includes/include_meta_link.php"; ?>
    <title>Mon carnet de recettes - Mes recettes de cuisine</title>
=======
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">   
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="/style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Mes recettes</title>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
 
</head>

<body>
<header >
        <?php $current_page = "my"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

<<<<<<< HEAD
    <main class="bloc bg_card_my <?php if(isset($return['error'])){echo 'smaller';} ?>">

        <section class="bloc">
            <h1 class="bloc__title bloc__title--bg">Mes recettes</h1>
            <div class="dropdown" id="dropDownParent">
            <button class="dropbtn" id="dropBtn">Filtrer</button>
                <form id="filterTable" class="dropdown__filter" name="filter" method="GET" action="#">
                    <button type="submit" class="btn filter_button" name="filter[entree]" value="Entrées">Entrées</button>
                    <button type="submit" class="btn filter_button" name="filter[plat]" value="Plats">Plats</button>
                    <button type="submit" class="btn filter_button" name="filter[dessert]" value="Desserts">Desserts</button>
                    <button type="submit" class="btn filter_button" name="filter[amuse]"value="Amuses bouches">Amuses bouches</button>
                    <button type="submit" class="btn filter_button" name="filter[accompagnement]"value="Accompagnements">Accompagnements</button>
                    <button type="submit" class="btn filter_button" name="filter[sauce]"value="Sauces">Sauces</button>
                    <button type="submit" class="btn filter_button" name="filter[boisson]"value="Boissons" >Boissons</button>
                    
                    <?php if(isset($filter)){
                        foreach($filter as $filterName){
                        if($filterName !== 'none'){
                        echo '<button type="submit" class="btn filter_button filter_button--supp" name="filter[\'none\']" value="none"> Supprimer le filtre </button>';
                        }
                    }
                }
                ?>
                </form>
                <button id="sortBtn" class="dropbtn">Trier</button>
                    <form id="sortTable" class="dropdown__sort" name="sort" method="GET" action="#">
                    <p class="row">Trier par : </p>
                    <button type="submit" class="btn sort_button" name="sort['desc']" value="desc"> Recettes les plus récentes </button>
                    <button type="submit" class="btn sort_button" name="sort['asc']" value="asc"> Recettes les plus anciennes </button>
                </form>
                </div>
            <div class="bloc__body--card"> 
                
=======
    <main class="bloc bg_card_my">

        <section class="bloc">
            <h2 class="bloc__title bloc__title--bg">Mes recettes</h2>
            <div class="bloc__body--card"> 
            
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                <?php 
                if(isset($return['error'])){  
                    foreach($return['error'] as $errors => $error){ 
                    echo 
                    '<div class="return_error error--grid text-center">
                        <h4>'.$error.'</h4>
                    </div>';
                    }
                }
                    ?>
<<<<<<< HEAD

                <?php
                if(isset($filter)){
                    foreach($filter as $filterName){
                        if($filterName !== 'none'){
                        echo '<h4 class="filter_name"> Catégorie : '.$filterName.'</h4>';
                        }
                    }
                }
                if(!isset($return['error'])){  

=======
                <form id="filterTable" name="filter" method="POST" action="#">
                    <button type="submit" class="btn filter_button" name="filter['entree']" value="1">Entrées</button>
                    <button type="submit" class="btn filter_button" name="filter['plat']" value="2">Plats</button>
                    <button type="submit" class="btn filter_button" name="filter['dessert']" value="3">Desserts</button>
                    <button type="submit" class="btn filter_button" name="filter['amuse']"value="4">Amuses bouches</button>
                    <button type="submit" class="btn filter_button" name="filter['accompagnement']"value="5">Accompagnements</button>
                    <button type="submit" class="btn filter_button" name="filter['sauce']"value="6">Sauces</button>
                    <button type="submit" class="btn filter_button" name="filter['boisson']"value="7" >Boissons</button>
                </form>

                <?php
                if(!isset($return['error'])){ 
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                    $i = 0;
                    foreach($recipes as $array => $recipe){

                    ?>
                    <div class="card">
                        <div class="card__header">
                            <?php 
<<<<<<< HEAD
                            echo '<img src="'.BASE_URL.'/Pictures/'.$recipe['name'].'"  class="card__img" alt="image de ma recette de cuisine" >';
=======
                            echo '<img src="/Pictures/'.$recipe['name'].'" 
                                class="card__img" alt="votre image" >';
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                            ?> 
                        </div>

                        <div class="card__body b0 card__body--h400">
                            <?php
                                echo '<h4 class="card__body__title">'.ucfirst($recipe['recipe_title']).'</h4>';
                            ?>
                            <button class="btn btn--collapse btn--collapse--my" type="button" data-toggle="collapse" data-target="<?php echo '#drop-collapse'.$i;?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                </svg>
                            </button>
                        
                            <div id="<?php echo 'drop-collapse'.$i;?>" class="bloc__collapse">
<<<<<<< HEAD
=======
                            <div class="card__button"> 
                                    <form class="noPad" action="/recipe_extension.php" method="get" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn--extend btn--extend--my" name="extend_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-box-arrow-up-right"></i> </button>
                                    </form>
                            </div>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                                <?php
                                    echo 
                                    '<ul class="list-group">
                                        <li class="list-group-item "> <i class="bi bi-tag"></i> Catégorie : '.$recipe['type'].'</li>
                                        <li class="list-group-item "> <i class="bi bi-people-fill"></i> Pour '.$recipe['guest_number'].' personnes </li>
                                        <li class="list-group-item "> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : '.$recipe['setup_time'].' minutes </li>
                                        <li class="list-group-item ">';
                                        if($recipe['level']=='faible'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Très facile';
                                        }
                                        if($recipe['level']=='moyen'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Niveau moyen';
                                        }
                                        if($recipe['level']=='élevé'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Difficile ';
                                        }
                                        echo
                                        '</li>
                                        <li class="list-group-item ">';
                                        if($recipe['price']=='faible'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Bon marché';
                                        }
                                        if($recipe['price']=='moyen'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Coût moyen';
                                        }
                                        if($recipe['price']=='élevé'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Coût élevé';
                                        }
                                        ?>
                                        </li>
<<<<<<< HEAD
                                    </ul>
                                <div class="bloc__row">
                                    <div class="card__button"> 
                                        <form class="noPad" action="<?php echo BASE_URL.'/recipe_extension.php'?>" method="get" enctype="multipart/form-data">
                                            <button type="submit" class="btn btn--extend btn--extend--my" name="extend_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-box-arrow-up-right"></i> Voir la fiche </button>
                                        </form>
                                    </div>  
                                    <div class="card__button"> 
                                        <form class="noPad" action="<?php echo BASE_URL.'/edit_recipes.php'?>" method="get" enctype="multipart/form-data">
                                            <button type="submit" class="btn btn--edit btn--edit--my" name="edit_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-pencil-fill"></i> Editer  </button>
                                        </form>
                                    </div>
=======
                                    </ul>  
                                <div class="card__button"> 
                                    <form class="noPad" action="/edit_recipes.php" method="get" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn--edit btn--edit--my" name="edit_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-pencil-fill"></i> Editer  </button>
                                    </form>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                                </div>
                                <?php $i++;?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if(!isset($return['error'])&& ($pages > 1)){ ?>
        <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($current_page_nb <= 1) ? "disabled" : "" ?>">
                    <a class="page-link" href="?page=<?= $current_page_nb - 1 ?>" aria-label="Previous" >
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-caret-left-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M10.205 12.456A.5.5 0 0 0 10.5 12V4a.5.5 0 0 0-.832-.374l-4.5 4a.5.5 0 0 0 0 .748l4.5 4a.5.5 0 0 0 .537.082z"/>
                            </svg>
                        </span>
                    </a>
                </li>
                <?php for($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($current_page_nb === $page) ? "disabled" : "" ?>">
                    <a href="?page=<?= $page ?>" class="page-link--middle"><?= $page ?></a>
                </li>
                <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($current_page_nb == $pages) ? "disabled" : "" ?>">
                    <a class="page-link" href="?page=<?= $current_page_nb + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-caret-right-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M5.795 12.456A.5.5 0 0 1 5.5 12V4a.5.5 0 0 1 .832-.374l4.5 4a.5.5 0 0 1 0 .748l-4.5 4a.5.5 0 0 1-.537.082z"/>
                            </svg>
                        </span>
                    </a>
                </li>
            </ul>
        <?php } ?> 
        </section>
    </main>

<<<<<<< HEAD
<?php 
include  "includes/footer.php"; 
include "includes/include_script.php";
?> 
=======
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/index.js"></script>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
</body>
</html>
