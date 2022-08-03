<?php
session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header("location: index.php");
    exit();
}

if(isset($_GET['page']) && !empty($_GET['page'])){
    $current_page_nb = (int) strip_tags($_GET['page']);

}else{
    $current_page_nb = 1;
}

include "includes/function_my_recipes.php"; 
    $user_id = $_SESSION['id'];
    $return = getRecipes($user_id, $current_page_nb); 

    if(!isset($return['error'])){
        $pages = $return['pages_nb'];
        $first_recipe = $return['first'];
        $recipes = $return['recipes'];
    }
    
?>
<!DOCTYPE html>
<html lang="en"> 
<head >
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">   
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">
  <Link href="http://localhost/TD_RECIPES/style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Mes recettes</title>
 
</head>

<body>
<header >
        <?php $current_page = "my"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main>

        <section class="bloc bg_card_my">
            <h2 class="bloc__title bloc__title--bg">Mes recettes</h2>
            <div <?php echo isset($return['error']) ? 'class="bloc__body error--grid"' : 'class="bloc__body--card"' ?> > 
            
                <?php 
                if(isset($return['error'])){  
                    foreach($return['error'] as $errors => $error){ 

                    echo 
                    '<div class="return_error error--grid text-center">
                        <h4>'.$error.'</h4>
                    </div>';
                    }
                }else{
                    $i = 0;

                    foreach($recipes as $array => $recipe){

                    ?>
                    <div class="card">
                        <div class="card__header">
                            <?php 
                            echo '<img src="http://localhost/TD_RECIPES/Pictures/'.$recipe['name'].'" 
                                class="card__img" alt="votre image" >';
                            ?> 
                        </div>
                        <div class="section-divider"></div>

                        <div class="card__body b0">
                            <?php
                                echo '<h4 class="card__body__title">'.ucfirst($recipe['recipe_title']).'</h4>';
                            ?>
                            <button class="btn btn--collapse btn--collapse--my" type="button" data-toggle="collapse" data-target="<?php echo '#drop-collapse'.$i;?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                </svg>
                            </button>
                        
                            <div id="<?php echo 'drop-collapse'.$i;?>" class="bloc__collapse">
                            <div class="card__button"> 
                                    <form class="noPad" action="http://localhost/TD_RECIPES/recipe_extension.php" method="get" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn--extend btn--extend--my" name="extend_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-box-arrow-up-right"></i> </button>
                                    </form>
                            </div>
                                <?php
                                    echo 
                                    '<ul class="list-group">
                                        <li class="list-group-item "> <i class="bi bi-tag"></i> Catégorie : '.$recipe['type'].'</li>
                                        <li class="list-group-item "> <i class="bi bi-people-fill"></i> Pour '.$recipe['guest_number'].' personnes </li>
                                        <li class="list-group-item "> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : '.$recipe['setup_time'].'</li>
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
                                    </ul>  
                                <div class="card__button"> 
                                    <form class="noPad" action="http://localhost/TD_RECIPES/edit_recipes.php" method="get" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn--edit btn--edit--my" name="edit_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> > <i class="bi bi-pencil-fill"></i> Editer  </button>
                                    </form>
                                </div>
                                <?php $i++;?>
                            </div>
                        </div>
                    </div>
            <?php } ?>
        <?php } ?>   
        </div>
        <?php if(!isset($return['error'])){ ?>
        <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($current_page_nb <= 1) ? "disabled" : "" ?>">
                    <a class="page-link" href="?page=<?= $current_page_nb - 1 ?>" aria-label="Previous" >
                        <span aria-hidden="true">
                        <i class="bi bi-chevron-left"></i>
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
                        <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </li>
            </ul>
        <?php } ?> 
        </section>
    </main>

<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="http://localhost/TD_RECIPES/js/index.js"></script>
</body>
</html>
