<?php
session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header("location: index.php");
    exit();
}

include "includes/function_add.php"; 
$user_id = $_SESSION['id'];

if(!empty($_POST)||!empty($_FILES['picture']['name'])){ 
    $return_form = ttt_form($_POST, $_FILES);
}

if(isset($return_form['success'])&& $return_form['success']=== true){ 
    $return_recipe = getrecipe($_POST, $_FILES, $user_id);
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width">
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">

  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_add_recipes.css">
  
  <title>Mes recettes - Ajouter une recette</title>

</head>
<body>
<header>
    <?php $current_page = "add"; ?>
    <?php include "includes/navbar.php" ?>
</header>


<div class="container-fluid justify-content-center">
    <div class="col col-lg-10 justify-self-center m-lg-auto m-4-auto">
        <h2 class="text-center py-lg-5 py-4 m-0 text-secondary">Ajouter une recette</h2>
        <div class="row justify-content-center m-auto pb-5">
            <div class="card col-10 col-lg-8">
            <form action="#" name='recipe' method="post" enctype="multipart/form-data">

                <?php 
                if(isset($return_recipe['message'])){
                    echo '<div class="success text-center">'.$return_recipe['message'].'</div>';
                }
                ?>
                 <?php
                if(isset($return_recipe['errors']['count'])){
                    echo '<div class="error text-center">'.$return_recipe['errors']['count'].'</div>';
                }
                if(isset($return_recipe['errors']['else'])){
                    echo '<div  class="error text-center" >'.$return_recipe['errors']['else'].'</div>';
                }
                
                ?>
                <div class="row justify-content-center justify-self-center m-auto p-4 text-center">
                    <label for="title" class="col-form-label col-10 col-lg-4 text-lg-right text-center">Titre de votre recette : </label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="text" id="title" name="title" class="form-control col-auto col-md-8 m-auto"
                        <?php 
                            if(!empty($_POST['title']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                    echo 'value="'.$_POST['title'].'"';
                            } ?> 
                        >
                        <?php if (isset($return_form['errors']['title'])) { ?>
                            <div class="error text-center">
                                <?php echo $return_form['errors']['title']; ?> 
                            </div>
                        <?php } ?>
                        <?php if (isset($return_form['errors']['sort'])) { ?>
                            <div class="error text-center">
                                <?php echo $return_form['errors']['sort']; ?> 
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row justify-content-center justify-self-center m-auto p-4 text-center">
                    <label for="guest" class="col-form-label col-10 col-lg-4 text-lg-right text-center ">Pour quel nombre de personnes : </label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="number" id="guest" name="guest" class="form-control col-auto col-md-8 m-auto"
                        <?php 
                            if(!empty($_POST['guest']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                    echo 'value="'.$_POST['guest'].'"';
                            }?> 
                        >
                        <?php if (isset($return_form['errors']['guest'])) { ?>
                            <div class="error text-center">
                                <?php echo $return_form['errors']['guest']; ?> 
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row justify-content-center justify-self-center m-auto p-4 text-center">
                    <label for="time" class="col-form-label col-10 col-lg-4 text-lg-right text-center">Temps de préparation : </label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="time" id="time" name="time" min="00:01" max="05:00" class="form-control col-auto col-md-8 m-auto "
                        <?php 
                            if(!empty($_POST['time']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo 'value="'.$_POST['time'].'"';
                        } ?> 
                        >
                        <?php if (isset($return_form['errors']['time'])) { ?>
                        <div class="error text-center">
                            <?php echo $return_form['errors']['time']; ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row justify-content-center m-auto py-lg-4">
                    <div class="col-8 col-lg-5 justify-self-center py-3 text-center">
                            <p>Niveau de complexité :</p>
                        
                            <input type="radio" class="form-check-input" id="weak"
                            name="level" value="faible">
                            <label for="weak" class="form-check-label pr-4">Faible</label>
                        
                            <input type="radio" class="form-check-input" id="medium"
                            name="level" value="moyen">
                            <label for="medium" class="form-check-label pr-4">Moyen</label>
                        
                            <input type="radio" class="form-check-input" id="strong"
                            name="level" value="élevé">
                            <label for="strong" class="form-check-label">Elevé</label>
                            <?php if(isset($return_form['errors']['level'])) { ?>
                                <div class="error text-center">
                                    <?php echo $return_form['errors']['level']; ?>
                                </div>
                                <?php } ?>
                                <?php if(isset($return_form['errors']['radio_level'])) { ?>
                                <div class="error text-center">
                                    <?php echo $return_form['errors']['radio_level']; ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-8 col-lg-5 justify-items-center py-3 text-center">
                            <p> Coût des ingrédients :</p>

                            <input class="form-check-input" type="radio"  id="faible"
                            name="price" value="faible">
                            <label for="faible" class="form-check-label pr-4">Faible</label>
                            <input type="radio" class="form-check-input" id="moyen"
                            name="price" value="moyen">
                            <label for="moyen" class="form-check-label pr-4">Moyen</label>

                            <input type="radio" class="form-check-input" id="eleve"
                            name="price" value="élevé">
                            <label for="eleve" class="form-check-label">Elevé</label>
                            <?php if(isset($return_form['errors']['price'])) { ?>
                                <div class="error text-center">
                                    <?php echo $return_form['errors']['price']; ?>
                                </div>
                                <?php } ?>
                                <?php if(isset($return_form['errors']['radio_price'])) { ?>
                                <div class="error text-center">
                                    <?php echo $return_form['errors']['radio_price']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-8 col-lg-8 justify-self-center m-auto py-4 text-center">
                        <label for="picture" class="form-label">Illustration de votre recette :</label>
                        <input type="file" id="picture" class="form-control" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                        <?php if (isset($return_form['errors']['picture'])) { ?>
                            <div class="error text-center">
                                <?php echo '</br>'.$return_form['errors']['picture']; ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($return_form['errors']['invalid'])) { ?>
                            <div class="error text-center">
                                <?php echo '</br>'.$return_form['errors']['invalid']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-6 m-auto py-5">
                        <button type="submit" class="btn w-100">Créer ma recette</button>
                    </div>
                </form> 
            </div>         
        </div>
    </div>
 
<?php include "includes/footer.php" ?>  
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
