<?php
session_start(); 
include "configuration.php";

include "includes/function_this_recipe.php"; 
	

    if(!isset($_GET['extend_btn'])){ 
         $error_btn ='<h3 class="return_error"> une erreur s\'est produite </h3>'; 
        
    }else{
        $recipe_id = $_GET['extend_btn'];
 
        $return = get_this_recipe($recipe_id); 
    
        if(!isset($return['error'])){
            $recipe = $return['recipe'];
        }
    
    }
    

?>
<!DOCTYPE html>
<html lang="en"> 
<head>
  
    <?php include "includes/include_meta_link.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    
    <title>Mon carnet de recettes - Fiche recette </title>

</head>

<body>
    <header>
        
        <?php 
        $current_page = 'extension';
        include "includes/navbar.php" 
        ?>
    </header>

    <main>
        
        <section class="bloc bloc--pad">
           <?php echo isset($return['error']) ? '<div class="bloc__grid error--grid">' : '' ?> 
                <?php 
                if(isset($return['error'])){  
                    foreach($return['error'] as $errors => $error){ 
                    echo 
                    '<div class="return_error error--grid text-center">
                        <h4>'.$error.'</h4>
                    </div>';
                    }
                }else{
                    foreach($recipe as $value){    
                    ?>
                    <page class="bloc__grid" id="recipe" backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm">
                        <page_header class="row">
                            <div class="bloc__body__title ">
                                <?php
                                    echo '<h1 class="header__title">'.ucfirst($value['recipe_title']).'</h1>';
                                ?>
                            </div>
                        </page_header>
                        <div class="bloc__header">
                            <?php 
                            echo '<img id="recetteImg" name="illustation_recette"src="'.BASE_URL.'/Pictures/'.$value['name'].'" 
                                class="bloc__header__img" alt="image de la recette de cuisine" >';
                            ?> 
                        </div>
                       
                        <div class="small__bloc">
                            <?php
                            echo 
                            '<ul class="list-group">
                                <li class="list-group-item list-group-item--p "> <i class="bi bi-tag"></i> Catégorie : '.$value['type'].'</li>
                                <li class="list-group-item list-group-item--p "> <i class="bi bi-people-fill"></i> Pour '.$value['guest_number'].' personnes </li>
                                <li class="list-group-item list-group-item--p "> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : '.$value['setup_time'].' minutes </li>
                                <li class="list-group-item list-group-item--p ">';
                                if($value['level']=='faible'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle"></i>
                                        <i class="bi bi-circle"></i>
                                        : Très facile';
                                }
                                if($value['level']=='moyen'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle"></i>
                                        : Niveau moyen';
                                }
                                if($value['level']=='élevé'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        : Difficile ';
                                }
                                echo
                                '</li>
                                <li class="list-group-item list-group-item--p ">';
                                if($value['price']=='faible'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle"></i>
                                        <i class="bi bi-circle"></i>
                                        : Bon marché';
                                }
                                if($value['price']=='moyen'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle"></i>
                                        : Coût moyen';
                                }
                                if($value['price']=='élevé'){
                                    echo 
                                        '<i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        <i class="bi bi-circle-fill"></i>
                                        : Coût élevé';
                                }
                                ?>
                                </li>
                            </ul>
                            </div>
                            <div class="small__bloc__ul">
                                <h5 class="subtitle"> Ingrédients : </h5>
                                <ul>
                                    <?php
                                    $a = array($value['field_ingredient1'], $value['field_ingredient2'], $value['field_ingredient3'], $value['field_ingredient4'], $value['field_ingredient5'], $value['field_ingredient6'], $value['field_ingredient7'], $value['field_ingredient8'], $value['field_ingredient9']);
                                        foreach($a as $key => $ing){
                                            if(!empty($ing)){
                                                echo '<li class="list-group-item">'.$ing.'</li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <page_footer class="bloc__text">
                                <h5 class="subtitle"> Déroulement de la recette : </h5>
                                <ul>
                                    <?php
                                    $b = array($value['step1'], $value['step2'], $value['step3'], $value['step4'], $value['step5']);
                                        foreach($b as $key => $step){
                                            if(!empty($step)){
                                                echo '<li class="list-group-item list-group-item--p" > '.$step.'</li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </page_footer>
                        </page>
                        <?php
                         if(isset($_SESSION['id']) || !empty($_SESSION['id']) && $_SESSION['id'] == $value['author_id']){?>
                            <div class="card__button"> 
                                <form action="<?php echo BASE_URL.'/edit_recipes.php'?>" method="get" enctype="multipart/form-data">
                                    <button type="submit" class="btn btn--edit" name="edit_btn" <?php echo 'value="'.$value['recipe_id'].'"'; ?> > <i class="bi bi-pencil-fill"></i> Editer  </button>
                                </form>
                            </div>
                        <?php } ?>
                    <?php } 
                }?> 
                </div>  
        </section>
    </main>
<?php 
    include  "includes/footer.php"; 
    include "includes/include_script.php";
?>



</body>
</html>

