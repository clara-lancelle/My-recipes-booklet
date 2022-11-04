<?php
session_start();

include "configuration.php";

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    if(isset($_COOKIE)){
        setcookie("PHPSESSID","",time()-3600,"/"); 
    }
    header("location: ".BASE_URL."/index.php");
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

<<<<<<< HEAD
  <?php include "includes/include_meta_link.php"; ?>
  <title>Mon carnet de recettes - Ajouter une recette</title>
=======
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
  <title>Mes recettes - Ajouter une recette</title>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

</head>
<body>
<header>
    <?php $current_page = "add"; ?>
    <?php include "includes/navbar.php" ?>
</header>


    <main>
        <section class="bloc add">
            <h1 class="bloc__title">Ajouter une recette</h1>
            <div class="bloc__body--form">

            <?php if(isset($return_recipe['message'])){?>
                    <div class="success">
                        <h3 id="success_message" class="return_message"><?=$return_recipe['message']?></h3>
                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                        </svg>
                    </div>
                   <?php } ?>
                <form id="form" class="form--bg" action="#" name='recipe' method="post" enctype="multipart/form-data">

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
                        <?php if(isset($return_form['errors']['select_cat'])) { ?>
                            <div class="return_error">
                                <?php echo $return_form['errors']['select_cat']; ?>
                            </div>
                            <?php } ?>
                        <label class="form-label" for="select"> Catégorie : </label>
<<<<<<< HEAD
                        <select name="cat" id="cat" class="form-control">s
                            <?php 
                                if(!empty($_POST['cat'])){
                                        $cat = $_POST['cat'];    
                                }
                                else{
                                    $cat = '';
                                }
                            ?>
                        <option value="<?=$cat?>"><?php echo $cat;?></option>
                            <?php 
                                if($cat!=="Entrées"){echo '<option value="Entrées">Entrées</option>';
                                }
                                if($cat!=="Plats"){echo '<option value="Plats">Plats</option>';
                                }
                                if($cat!=="Desserts"){echo '<option value="Desserts">Desserts</option>';
                                }
                                if($cat!=="Amuses bouches"){echo '<option value="Amuses bouches">Amuses bouches</option>';
                                }
                                if($cat!=="Accompagnements"){echo '<option value="Accompagnements">Accompagnements</option>';
                                }
                                if($cat!=="Sauces"){echo '<option value="Sauces">Sauces</option>';
                                }
                                if($cat!=="Boissons"){echo '<option value="Boissons">Boissons</option>';
                                }
                            ?>
                    </select>
=======
                        <select name="cat" id="cat" class="form-control"  >
                            <option 
                                <?php 
                                if(!empty($_POST['cat']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo 'value="'.$_POST['cat'].'"';
                                } ?>
                                > 
                                <?php 
                                if(!empty($_POST['cat']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                        echo $_POST['cat'];
                                } ?> 
                            </option>
                            <option value="Entrées">Entrées</option>
                            <option value="Plats">Plats</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Amuses bouches">Amuses bouches</option>
                            <option value="Accompagnements">Accompagnements</option>
                            <option value="Sauces">Sauces</option>
                            <option value="Boissons">Boissons</option>
                        </select>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
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
                        <label for="time" class="form-label">Temps de préparation en minutes : </label>
                        <input type="number" id="time" name="time" min="1" max="1000" class="form-input margin-top form-input--small"
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
                        name="level" value="faible" 
                        <?php 
                            if(!empty($_POST['level']) && $_POST['level']=='faible' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="weak" class="form-check-label pr-4">Faible</label>
                    
                        <input type="radio" class="form-check-input" id="medium"
                        name="level" value="moyen"
                        <?php 
                            if(!empty($_POST['level']) && $_POST['level']=='moyen' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="medium" class="form-check-label pr-4">Moyen</label>
                    
                        <input type="radio" class="form-check-input" id="strong"
                        name="level" value="élevé"
                        <?php 
                            if(!empty($_POST['level']) && $_POST['level']=='élevé' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="strong" class="form-check-label">Elevé</label>
                        <?php if(isset($return_form['errors']['level'])) { ?>
                            <div class="return_error return_error row">
                                <?php echo $return_form['errors']['level']; ?>
                            </div>
                            <?php } ?>
                            <?php if(isset($return_form['errors']['radio_level'])) { ?>
                            <div class="return_error return_error row">
                                <?php echo $return_form['errors']['radio_level']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form__field form__field--radio">
                        <legend class="form-label--radio"> Coût des ingrédients :</legend>

                        <input class="form-check-input" type="radio"  id="faible"
                        name="price" value="faible"
                        <?php 
                            if(!empty($_POST['price']) && $_POST['price']=='faible' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="faible" class="form-check-label">Faible</label>
                        <input type="radio" class="form-check-input" id="moyen"
                        name="price" value="moyen"
                        <?php 
                            if(!empty($_POST['price']) && $_POST['price']=='moyen' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="moyen" class="form-check-label">Moyen</label>

                        <input type="radio" class="form-check-input" id="eleve"
                        name="price" value="élevé"
                        <?php 
                            if(!empty($_POST['price']) && $_POST['price']=='élevé' && (isset($return_form['errors']) || isset($return_recipe['errors']))){
                                echo 'checked';
                        } ?> 
                        >
                        <label for="eleve" class="form-check-label">Elevé</label>
                            <?php if(isset($return_form['errors']['price'])) { ?>
<<<<<<< HEAD
                            <div class="return_error return_error row">
=======
                            <div class="return_error">
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                                <?php echo $return_form['errors']['price']; ?>
                            </div>
                            <?php } ?>
                            <?php if(isset($return_form['errors']['radio_price'])) { ?>
                            <div class="return_error return_error row">
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
<<<<<<< HEAD
                            <div class="return_error">
                                <?php echo $return_form['errors']['step']; ?>
                            </div>
                        <?php } ?>
                        <?php 
                            if(!empty($_POST['step1']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                $valeur1 = $_POST['step1'];
                            }else{
                                $valeur1 = '1.';
                            }
                        ?>  
                        <textarea name="step1" id="steps" cols="30" rows="4"><?= $valeur1 ?></textarea>
                        
                        <?php 
                            if(!empty($_POST['step2']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                $valeur2 = $_POST['step2'];
                            }else{
                                $valeur2 = '2.';
                            }
                        ?>  
                        <textarea name="step2" id="steps" cols="30" rows="4"><?= $valeur2 ?></textarea>
                        
                        <?php 
                            if(!empty($_POST['step3']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                $valeur3 = $_POST['step3'];
                            }else{
                                $valeur3 = '3.';
                            }
                        ?>  
                        <textarea name="step3" id="steps" cols="30" rows="4"><?= $valeur3 ?></textarea>
                        
                        <?php 
                            if(!empty($_POST['step4']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                $valeur4 = $_POST['step4'];
                            }else{
                                $valeur4 = '4.';
                            }
                        ?>   
                       <textarea name="step4" id="steps" cols="30" rows="4"><?= $valeur4 ?></textarea>
                        
                       <?php 
                            if(!empty($_POST['step5']) && isset($return_form['errors']) || isset($return_recipe['errors'])){
                                $valeur5 = $_POST['step5'];
                            }else{
                                $valeur5 = '5.';
                            }
                        ?>  
                       <textarea name="step5" id="steps" cols="30" rows="4"><?= $valeur5 ?></textarea>
                        
                    </div>
                    <div class="form__field  form__field__img">
                        <label for="picture" class="form-label">Illustration de votre recette :</label>
                            <?php 
                            if(isset($return_form['temporary_file'])&& !empty($return_form['temporary_file'])){
                                $current_pic_path = BASE_URL.'/Pictures/tmp/'.$return_form['temporary_file'];
                                $picToEdit = $return_form['temporary_file']; 
                                                                                                                                                                                                                                                                                  
                            ?>
                            <img class="picToEdit" src="<?php echo $current_pic_path;?>" alt="votre image"/>
                            <input type="hidden" name="picToEdit" value="<?=$picToEdit?>"/>
                            <?php } ?>

                        <input type="file" id="picture" class="form-input margin-top" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                        <?php if (isset($return_form['errors']['img'])) {
                                foreach($return_form['errors']['img'] as $error_img){?>
                                    <div class="return_error">
                                        <?php echo '<h3 class="return_error">'.$error_img.'</h3>'; ?>
                                    </div>
                                <?php }
                            }?> 
=======
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
                        <?php if (isset($return_form['errors']['img'])) {
                                foreach($return_form['errors']['img'] as $error_img){
                                    ?>
                                    <div class="return_error">
                                        <?php echo '<h3 class="return_error">'.$error_img.'</h3>'; ?>
                                    </div>
                                    <?php  }
                                }   ?> 
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
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
