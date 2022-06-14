<?php
session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
   header("location: login.php");
   exit();
}

// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $current_page_nb = (int) strip_tags($_GET['page']);

}else{
    $current_page_nb = 1;
}
    include "includes/function_all_recipes.php"; 
    $user_id = $_SESSION['id'];
    $return = get_all_recipes($current_page_nb); 

    $pages = $return['pages_nb'];
    $first_recipe = $return['first'];
    $recipes = $return['recipes'];

?>

<!DOCTYPE html>
<html lang="en" > 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_all_recipes.css">
  
  <title>Mes recettes - Toutes les recettes</title>

</head>

<body>
    <header>
    <?php $current_page = "all"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <div class="container col-12 col-lg-10 justify-content-center">
        <div class="col col-12 justify-self-center m-auto pb-5">
            <h2 class="text-center py-lg-5 py-3 m-0 text-secondary">Toutes les recettes</h2>
            <div class="row col-12 m-auto">
                <div class="card-group pt-5 p-3 justify-content-center m-auto">
            <?php
                $i = 0;
                foreach($recipes as $recipe => $array){?>

                <div class="col col-12 col-md-6 col-xl-4 justify-self-center justify-content-center p-3 p-md-4 m-auto">
                    <div class="card bg-secondary m-auto">
                        <div class="card-header m-auto d-flex align-items-center">
                        <?php
                            echo '<img src="http://localhost/TD_RECIPES/Pictures/'.$array['name'].'" class="card-img-top" alt="image">';                  
                        ?>
                        </div>
                        <div class="card-body p-2">
                        <?php
                            echo '<h4 class="card-title text-center">'.ucfirst($array['recipe_title']).'</h4>';
                            ?>

                            <button class="btn d-lg-none" type="button" data-toggle="collapse" data-target="<?php echo '#drop-collapse'.$i;?>">
                                <span class="navbar-light"><span class="navbar-toggler-icon"></span></span>
                            </button>
    
                            <div id="<?php echo 'drop-collapse'.$i;?>" class="collapse d-lg-block">
                                <?php    
                                    echo 
                                    '<ul class="list-group list-group-flush bg-secondary">
                                        <li class="list-group-item bg-secondary"><i class="bi bi-people-fill"></i> Pour '.$array['guest_number'].' personnes </li>
                                        <li class="list-group-item bg-secondary"> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : '.$array['setup_time'].'</li>
                                        <li class="list-group-item bg-secondary">';
                                        if($array['level']=='faible'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Très facile';
                                        }
                                        if($array['level']=='moyen'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Niveau moyen';
                                        }
                                        if($array['level']=='élevé'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Difficile ';
                                        }
                                        echo
                                        '</li>
                                        <li class="list-group-item bg-secondary">';
                                        if($array['price']=='faible'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Bon marché';
                                        }
                                        if($array['price']=='moyen'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Coût moyen';
                                        }
                                        if($array['price']=='élevé'){
                                            echo 
                                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Coût élevé';
                                        }
                                        '</li>';
                                     ?>
                                     </ul>
                                
                                <?php

                                if($user_id == $array['author_id']){?>
                                <div class="card-body pt-4 p-m-auto text-center"> 
                                    <form action="http://localhost/TD_RECIPES/edit_recipes.php" method="get" enctype="multipart/form-data" >
                                        <button class="edit p-1 px-3" type="submit" name="edit_btn" <?php echo 'value="'.$array['recipe_id'].'"'; ?>>Editer</button>
                                    </form>
                                    </div>
                            <?php }
                            $i++; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>

        <ul class="pagination justify-content-center pt-5">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($current_page_nb == 1) ? "disabled" : "" ?>">
                <a class="page-link text-secondary" href="all_recipes.php/?page=<?= $current_page_nb - 1 ?>" aria-label="Previous" >
                <span aria-hidden="true">&laquo;</span>
            </a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($current_page_nb == $page) ? "active" : "" ?>">
                <a href="all_recipes.php/?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($current_page_nb == $pages) ? "disabled" : "" ?>">
            <a class="page-link text-secondary" href="all_recipes.php//?page=<?= $current_page_nb + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>

    </div>
</div>
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
 </html>
