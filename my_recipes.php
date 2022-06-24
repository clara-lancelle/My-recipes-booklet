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
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_my_recipes.css">
  
  <title>Mes recettes - Mes recettes</title>
 
</head>

<body>
<header >
        <?php $current_page = "my"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <div class="container-fluid justify-content-center col-12 pb-4">

        <div class="col col-12 col-lg-10 justify-self-center m-auto ">
            <h2 class="py-3 py-md-5 text-secondary text-center">Mes recettes</h2>
            <div class="row">
            
                <?php 
                if(isset($return['error'])){  
                    foreach($return['error'] as $errors => $error){ 

                    echo 
                    '<div class="error">
                        <h4>'.$error.'</h4>
                    </div>';
                    }
                }else{
                    echo'<div class="card-group pt-2 pt-md-5 p-3 justify-content-center m-auto">';
                    $i = 0;

                    foreach($recipes as $array => $recipe){

                    ?>
                <div class="col col-md-6 col-12 col-xl-4 justify-self-center justify-content-center p-3 p-md-4 m-auto " >
                    <div class="card bg-secondary justify-content-center m-auto p-3">
                        
                        <div class="card-header m-auto d-flex align-items-center">
                            <?php 
                            echo '<img src="http://localhost/TD_RECIPES/Pictures/'.$recipe['name'].'" 
                             class="card-img-top" alt="votre image" >';
                        ?> 
                        </div>
                        <div class="card-body bg-secondary p-2 p-md-auto">
                        <?php
                            echo '<h3 class="card-title text-center">'.ucfirst($recipe['recipe_title']).'</h3>';
                        ?>

                        <button class="btn d-lg-none" type="button" data-toggle="collapse" data-target="<?php echo '#drop-collapse'.$i;?>">
                            <span class="navbar-light"><span class="navbar-toggler-icon"></span></span>
                        </button>
                        
                        <div id="<?php echo 'drop-collapse'.$i;?>" class="collapse d-lg-block ">
                            <?php
                            echo 
                            '<ul class="list-group list-group-flush bg-secondary ">
                                <li class="list-group-item bg-secondary"> <i class="bi bi-people-fill"></i> Pour '.$recipe['guest_number'].' personnes</li>
                                <li class="list-group-item bg-secondary"> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : '.$recipe['setup_time'].'</li>
                                <li class="list-group-item bg-secondary">';
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
                                <li class="list-group-item bg-secondary">';
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
                                '</li>';    
                            ?>
                            </ul>
                            <div class="card-body text-center pt-4 p-m-auto"> 
                                <form action="http://localhost/TD_RECIPES/edit_recipes.php" method="get" enctype="multipart/form-data">
                                    <button type="submit" class="btn" name="edit_btn" <?php echo 'value="'.$recipe['recipe_id'].'"'; ?> style="background-color: rgb(63, 66, 62); color:white; border-radius:10px; padding: 5px;" > Modifier ma recette </button>
                                </form>
                            </div>
                            <?php $i++;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
        </div>      
    </div>
    <?php if(!isset($return['error'])){ ?>
    <ul class="pagination justify-content-center pt-5">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($current_page_nb == 1) ? "disabled" : "" ?>">
                <a class="page-link text-secondary" href="my_recipes.php/?page=<?= $current_page_nb - 1 ?>" aria-label="Previous" >
                <span aria-hidden="true">&laquo;</span>
            </a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($current_page_nb == $page) ? "active" : "" ?>">
                    <a href="my_recipes.php/?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($current_page_nb == $pages) ? "disabled" : "" ?>">
                <a  class="page-link text-secondary" href="my_recipes.php//?page=<?= $current_page_nb + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>
        <?php } ?>
    </div>
</div>

<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
