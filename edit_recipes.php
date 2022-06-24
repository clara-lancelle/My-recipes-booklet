<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
  <!-- Required meta tags -->
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">
  
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_edit_recipes.css">
  
  <title>Mes recettes - Edition </title>


</head>

<body>
<header>
        <?php $current_page = "ed"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <div class="container justify-content-center mb-4">

        <h2 class="text-center py-lg-5 py-3 m-0">Editer ma recette</h2>
        <?php 

            include "includes/function_edit_recipes.php"; 
            $user_id = $_SESSION['id'];
        
            if(!isset($_GET['edit_btn'])){ echo '<h3 class="error"> une erreur s\'est produite </h3>';
            
            }else{
        
                $recipe_id = $_GET['edit_btn'];

                $recipe_data = getData($recipe_id); 

                foreach($recipe_data as $data){

                    if(!empty($_POST)){ 
            
                        $return_edit = getEdit($_POST,$_FILES,$recipe_id);
                    
                    }
                    if(isset($return_edit['message'])){
                        echo '<h3 class="success">'.$return_edit['message'].'</h3>';
                        exit();
                    }
            
            
        ?>
            <div class="row col-12 justify-items-center m-auto">
                <div class="card col-12 col-lg-10 mb-3 m-auto">
                <form action="#" name='form' method="post" class="col-10 text-center m-auto py-lg-5 py-2" enctype="multipart/form-data">

                    <div class="mb-3 justify-items-center m-auto">
                        <?php
                            if(isset($data['errors']['empty'])){
                                
                                echo '<h3 class="error">'.$data['errors']['empty'].'</h3>'; 
                            }
                            if(isset($return_edit['errors']['empty'])){
                                echo '<h3 class="error">'.$return_edit['errors']['empty'].'</h3>';
                            }
                            if(isset($return_edit['errors']['db'])){
                                echo '<h3 class="error">'.$return_edit['errors']['db'].'</h3>';
                            }
                            
                            if(isset($return_edit['errors']['sort'])){
                                echo '<h3 class="error">'.$return_edit['errors']['sort'].'</h3>';
                                }
                        ?>
                    </div>
                    <div class="col-10 justify-self-center m-auto py-4">
                        <label for="title" class="form-label">Titre de votre recette :</label>
                        <input type="text" id="title" class="form-control" name="title"
                        <?php 
                            if(!empty($data['recipe_title'])&& empty($_POST['title'])){
                                    echo 'value="'.$data['recipe_title'].'"';
                                }
                                
                                if(!empty($_POST['title'])){
                                    echo 'value="'.$_POST['title'].'"';
   
                        } ?>>
                        
                    </div>
                    <div class="row m-auto justify-content-center">
                        <div class="col-10 col-lg-6 justify-self-center py-3">
                            <label for="guest" class="form-label">Pour quel nombre de personnes : </label>
                            <input type="number" id="guest" class="form-control" name="guest"
                            <?php 
                                if(!empty($data['guest_number'])&& empty($_POST['guest'])){
                                        echo 'value="'.$data['guest_number'].'"';
                                    }
                                    
                                    if(!empty($_POST['guest'])){
                                        echo 'value="'.$_POST['guest'].'"';

                            } ?>>
                        </div>
                        <div class="col-10 col-lg-6 justify-self-center py-3">
                            <label for="time" class="form-label">Temps de préparation : </label>
                            <input type="time" id="time" class="form-control" name="time" min="00:01" max="05:00"
                            <?php 
                                if(!empty($data['setup_time'])&& empty($_POST['time'])){
                                        echo 'value="'.$data['setup_time'].'"';
                                    }
                                    
                                    if(!empty($_POST['time'])){
                                        echo 'value="'.$_POST['time'].'"';

                            } ?>>
                        </div>
                    </div>
                    <div class="row justify-content-center m-auto">
                        <?php if(isset($return_edit['errors']['radio_level'])){echo '<h3 class="error">'.$return_edit['errors']['radio_level'].'</h3>';}?>
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
                        </div>

                        <?php if(isset($return_edit['errors']['rado_price'])){
                            echo '<h3 class="error">'.$return_edit['errors']['radio_price'].'</h3>';
                            }?>
                        <div class="col-8 col-lg-5 justify-items-center py-3 text-center">
                            <p > Coût des ingrédients :</p>

                                <input class="form-check-input" type="radio"  id="faible"
                                name="price" value="faible">
                                <label for="faible" class="form-check-label pr-4">Faible</label>
                                <input type="radio" class="form-check-input" id="moyen"
                                name="price" value="moyen">
                                <label for="moyen" class="form-check-label pr-4">Moyen</label>

                                <input type="radio" class="form-check-input" id="eleve"
                                name="price" value="élevé">
                                <label for="eleve" class="form-check-label">Elevé</label>
                        </div>
                    </div>
                    <div class="col-8 col-lg-8 justify-self-center m-auto py-4">
                        <label for="picture" class="form-label" >Illustration de votre recette :</label>
                        <input type="file" id="picture" class="form-control" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                        <?php if(isset($return_edit['errors']['invalid'])){
                            echo '<h3 class="error">'.$return_edit['errors']['invalid'].'</h3>';
                        }?>
                    </div>
                    <div class="col-6 m-auto py-lg-5 py-3 justify-content-center">            
                        <button type="submit" class="btn justify-self-center w-100"> Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        }
    }
?>
</div>
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>


