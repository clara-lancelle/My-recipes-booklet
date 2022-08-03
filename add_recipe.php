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
  <Link href="style.css" rel="stylesheet" type="text/css" />
  <title>Mes recettes - Ajouter une recette</title>

</head>
<body>
<header>
    <?php $current_page = "add"; ?>
    <?php include "includes/navbar.php" ?>
</header>


    <main>
        <section class="bloc add">
            <h2 class="bloc__title">Ajouter une recette</h2>
            <div class="bloc__body--form">
                <form class="form--bg" action="#" name='recipe' method="post" enctype="multipart/form-data">

                    <?php 
                    if(isset($return_recipe['message'])){
                        echo '<div class="return_message text-center">'.$return_recipe['message'].'</div>';
                    }
                    ?>
                    <?php
                    if(isset($return_recipe['errors']['count'])){
                        echo '<div class="return_error text-center">'.$return_recipe['errors']['count'].'</div>';
                    }
                    if(isset($return_recipe['errors']['else'])){
                        echo '<div  class="return_error text-center" >'.$return_recipe['errors']['else'].'</div>';
                    }
                    
                    ?>

                    <div class="form__field">
                        <label for="title" class="form-label">Titre de votre recette : </label>
                        <input type="text" id="title" name="title" class="form-input margin-top"
                            <?php 
                                if(!empty($_POST['title']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['title'].'"';
                                } ?> 
                            >
                            <?php if (isset($return_form['errors']['title'])) { ?>
                                <div class="return_error">
                                    <?php echo $return_form['errors']['title']; ?> 
                                </div>
                            <?php } ?>
                            <?php if (isset($return_form['errors']['sort'])) { ?>
                                <div class="return_error">
                                    <?php echo $return_form['errors']['sort']; ?> 
                                </div>
                            <?php } ?>
                    </div>
                    <div class="form__field bloc_in_bloc">
                        <?php if (isset($return_form['errors']['cat'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['cat']; ?>
                        </div>
                        <?php } ?>
                        <label class="form-label" for="select"> Catégorie : </label>
                        <select name="cat" id="cat" class="form-control" <?php 
                                if(!empty($_POST['cat']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['cat'].'"';
                                } ?> >
                            <option value=""> ... </option>
                            <option value="entrees">Entrées</option>
                            <option value="plats">Plats</option>
                            <option value="desserts">Desserts</option>
                            <option value="amuses">Amuses bouches</option>
                            <option value="accompagnements">Accompagnements</option>
                            <option value="sauces">Sauces</option>
                            <option value="boissons">Boissons</option>
                        </select>
                    </div> 
                    <div class="form__field bloc_in_bloc">
                        <label for="guest" class="form-label">Pour combien de personnes : </label>
                        <input type="number" id="guest" name="guest" class="form-input margin-top form-input--small"
                            <?php 
                                if(!empty($_POST['guest']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['guest'].'"';
                                }?> 
                            >
                            <?php if (isset($return_form['errors']['guest'])) { ?>
                                <div class="return_error">
                                    <?php echo $return_form['errors']['guest']; ?> 
                                </div>
                            <?php } ?>
                    </div>

                    <div class="form__field bloc_in_bloc">
                        <label for="time" class="form-label">Temps de préparation : </label>
                        <input type="time" id="time" name="time" min="00:01" max="05:00" class="form-input margin-top form-input--small"
                        <?php 
                            if(!empty($_POST['time']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo 'value="'.$_POST['time'].'"';
                        } ?> 
                        >
                        <?php if (isset($return_form['errors']['time'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['time']; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form__field form__field--radio">
                        <legend class="form-label--radio">Niveau de complexité :</legend>
                    
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
                            <div class="return_error">
                                <?php echo $return_form['errors']['level']; ?>
                            </div>
                            <?php } ?>
                            <?php if(isset($return_form['errors']['radio_level'])) { ?>
                            <div class="return_error">
                                <?php echo $return_form['errors']['radio_level']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form__field form__field--radio">
                        <legend class="form-label--radio"> Coût des ingrédients :</legend>

                        <input class="form-check-input" type="radio"  id="faible"
                        name="price" value="faible">
                        <label for="faible" class="form-check-label">Faible</label>
                        <input type="radio" class="form-check-input" id="moyen"
                        name="price" value="moyen">
                        <label for="moyen" class="form-check-label">Moyen</label>

                        <input type="radio" class="form-check-input" id="eleve"
                        name="price" value="élevé">
                        <label for="eleve" class="form-check-label">Elevé</label>
                        <?php if(isset($return_form['errors']['price'])) { ?>
                            <div class="return_error">
                                <?php echo $return_form['errors']['price']; ?>
                            </div>
                            <?php } ?>
                            <?php if(isset($return_form['errors']['radio_price'])) { ?>
                            <div class="return_error">
                                <?php echo $return_form['errors']['radio_price']; ?>
                            </div>
                        <?php } ?>
                    </div>      
                    <div class="form__field field__ing">
                        <legend> Ingrédients : </legend> 
                        <?php if (isset($return_form['errors']['ing'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['ing']; ?>
                        </div>
                        <?php } ?>
                                <input type="text" class="form-input ing" name="ing1" placeholder="100g de farine"
                                <?php 
                                    if(!empty($_POST['ing1']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing1'].'"';
                                } ?> 
                                >
                                <input type="text" class="form-input ing" name="ing2" <?php 
                                if(!empty($_POST['ing2']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing2'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing3" <?php 
                                if(!empty($_POST['ing3']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing3'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing4" <?php 
                                if(!empty($_POST['ing4']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing4'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing5" <?php 
                                if(!empty($_POST['ing5']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing5'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing6" <?php 
                                if(!empty($_POST['ing6']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing6'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing7" <?php 
                                if(!empty($_POST['ing7']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing7'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing8" <?php 
                                if(!empty($_POST['ing8']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing8'].'"';
                                } ?> >
                                <input type="text" class="form-input ing" name="ing9" <?php 
                                if(!empty($_POST['ing9']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['ing9'].'"';
                                } ?> >
                    </div>
                    <div class="steps">
                        <legend> Etapes de votre recette : </legend>
                        <?php if (isset($return_form['errors']['step'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['step']; ?>
                        </div>
                        <?php } ?>
                        <textarea name="step1" id="steps" cols="30" rows="3" ><?php 
                            if(!empty($_POST['step1']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo $_POST['step1'];}else{ echo '1.';
                        } ?> </textarea>
                        <textarea name="step2" id="steps" cols="30" rows="3" ><?php 
                            if((!empty($_POST['step2'])) && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo $_POST['step2'];}else{ echo '2.';
                            } ?> </textarea>
                        <textarea name="step3" id="steps" cols="30" rows="3"><?php 
                            if((!empty($_POST['step3'])) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo $_POST['step3'];}else{ echo '3.';
                            } ?> </textarea>
                        <textarea name="step4" id="steps" cols="30" rows="3" ><?php 
                            if(!empty($_POST['step4']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo $_POST['step4'];}else{ echo '4.';
                            } ?> </textarea>
                        <textarea name="step5" id="steps" cols="30" rows="3" ><?php 
                            if(!empty($_POST['step5']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                echo $_POST['step5'];}else{ echo '5.';
                            } ?> </textarea>
                    </div>
                    <div class="form__field">
                        <label for="picture" class="form-label">Illustration de votre recette :</label>
                        <input type="file" id="picture" class="form-input margin-top" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                        <?php if (isset($return_form['errors']['picture'])) { ?>
                            <div class="return_error">
                                <?php echo '</br>'.$return_form['errors']['picture']; ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($return_form['errors']['invalid'])) { ?>
                            <div class="return_error">
                                <?php echo '</br>'.$return_form['errors']['invalid']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="btn--center">
                        <button type="submit" class="btn btn--add ">Créer ma recette</button>
                    </div>
                </form> 
            </div> 
        </section>
    </main>        
<?php include "includes/footer.php" ?>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="http://localhost/TD_RECIPES/js/index.js"></script>
</body>
</html>
