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
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Edition </title>


</head>

<body>
    <header>
        <?php 
        $current_page = 'edit';
        include "includes/navbar.php" ?>
    </header>

    <main>

        <section class="bloc">

        <h2 class="bloc__title">Editer ma recette</h2>
        <?php 

            include "includes/function_edit_recipes.php"; 
            $user_id = $_SESSION['id'];
        
            if(!isset($_GET['edit_btn'])){ echo '<h3 class="return_error"> une erreur s\'est produite </h3>';
            
            }else{
        
                $recipe_id = $_GET['edit_btn'];

                $recipe_data = getData($recipe_id); 

                foreach($recipe_data as $data){

                    if(!empty($_POST)){ 
            
                        $return_edit = getEdit($_POST,$_FILES,$recipe_id);
                    
                    }
                    if(isset($return_edit['message'])){
                        echo '<h3 class="return_message">'.$return_edit['message'].'</h3>';
                        exit();
                    }
        ?>
                
            <form action="#" name='form' method="post" enctype="multipart/form-data">

                <?php
                    if(isset($data['errors']['empty'])){
                        
                        echo '<h3 class="return_error">'.$data['errors']['empty'].'</h3>'; 
                    }
                    if(isset($return_edit['errors']['empty'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['empty'].'</h3>';
                    }
                    if(isset($return_edit['errors']['db'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['db'].'</h3>';
                    }
                    
                    if(isset($return_edit['errors']['sort'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['sort'].'</h3>';
                        }
                ?>
                <div class="form__field">
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
                <div class="form__field">
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
                <div class="form__field">
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
                <div class="form__field--radio">
                <?php if(isset($return_edit['errors']['radio_level'])){echo '<h3 class="return_error">'.$return_edit['errors']['radio_level'].'</h3>';}?>
                    <p class="form-label--radio">Niveau de complexité :</p>
                
                        <input type="radio" class="form-check-input" id="weak"
                        name="level" value="faible">
                        <label for="weak" class="form-check-label">Faible</label>
                    
                        <input type="radio" class="form-check-input" id="medium"
                        name="level" value="moyen">
                        <label for="medium" class="form-check-label">Moyen</label>
                    
                        <input type="radio" class="form-check-input" id="strong"
                        name="level" value="élevé">
                        <label for="strong" class="form-check-label">Elevé</label>
                </div>   
                <div class="form__field--radio">
                    <?php if(isset($return_edit['errors']['rado_price'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['radio_price'].'</h3>';
                        }?>
                    <p class="form-label--radio"> Coût des ingrédients :</p>

                        <input class="form-check-input" type="radio"  id="faible"
                        name="price" value="faible">
                        <label for="faible" class="form-check-label">Faible</label>
                        <input type="radio" class="form-check-input" id="moyen"
                        name="price" value="moyen">
                        <label for="moyen" class="form-check-label">Moyen</label>

                        <input type="radio" class="form-check-input" id="eleve"
                        name="price" value="élevé">
                        <label for="eleve" class="form-check-label">Elevé</label>
                </div>
                <div class="form__field">
                    <label for="picture" class="form-label" >Illustration de votre recette :</label>
                    <input type="file" id="picture" class="form-control" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                    <?php if(isset($return_edit['errors']['invalid'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['invalid'].'</h3>';
                    }?>
                </div>
                <div class="btn--center">            
                    <button type="submit" class="btn"> Enregistrer les modifications</button>
                </div>
            </form>
            <?php }  }?>
        </section>
    </main>
<?php include "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="http://localhost/TD_RECIPES/js/index.js"></script>
</body>

</html>


