<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
  <!-- Required meta tags -->
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
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
                
            <form  class="form--bg" action="#" name='form' method="post" enctype="multipart/form-data">

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
                <div class="form__field bloc_in_bloc">
                    <?php if(isset($return_form['errors']['select_cat'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['select_cat']; ?>
                        </div>
                        <?php } ?>
                    <label class="form-label" for="select"> Catégorie : </label>
                    <select name="cat" id="cat" class="form-control" >
                        <option  
                            <?php 
                            if(!empty($data['type'])&& empty($_POST['cat'])){
                                    echo 'value="'.$data['type'].'"';
                                }
                                
                                if(!empty($_POST['cat'])){
                                    echo 'value="'.$_POST['cat'].'"';
                            } 
                            ?> > <?php if(!empty($data['type'])&& empty($_POST['cat'])){
                                echo $data['type'];
                            }
                            if(!empty($_POST['cat'])){
                                echo $_POST['cat'];
                            }   ?>
                        </option>
                        <option value="Entrées">Entrées</option>
                        <option value="Plats">Plats</option>
                        <option value="Desserts">Desserts</option>
                        <option value="Amuses bouches">Amuses bouches</option>
                        <option value="Accompagnements">Accompagnements</option>
                        <option value="Sauces">Sauces</option>
                        <option value="Boissons">Boissons</option>
                    </select>
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
                    <label for="time" class="form-label">Temps de préparation en minutes : </label>
                    <input type="number" id="time" class="form-control" name="time" min="1" max="1000"
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
                <div class="form__field field__ing">
                        <legend> Ingrédients : </legend> 
                        <?php if (isset($return_form['errors']['ing'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['ing']; ?>
                        </div>
                        <?php } ?>
                                <input type="text" class="form-input ing" name="ing1" placeholder="100g de farine"
                                <?php 
                                if(!empty($data['field_ingredient1'])&& empty($_POST['ing1'])){
                                        echo 'value="'.$data['field_ingredient1'].'"';
                                }   
                                if(!empty($_POST['ing1'])){
                                        echo 'value="'.$_POST['ing1'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing2"
                                <?php 
                                if(!empty($data['field_ingredient2'])&& empty($_POST['ing2'])){
                                        echo 'value="'.$data['field_ingredient2'].'"';
                                }   
                                if(!empty($_POST['ing2'])){
                                        echo 'value="'.$_POST['ing2'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing3"
                                <?php 
                                if(!empty($data['field_ingredient3'])&& empty($_POST['ing3'])){
                                        echo 'value="'.$data['field_ingredient3'].'"';
                                }   
                                if(!empty($_POST['ing3'])){
                                        echo 'value="'.$_POST['ing3'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing4" 
                                <?php 
                                if(!empty($data['field_ingredient4'])&& empty($_POST['ing4'])){
                                        echo 'value="'.$data['field_ingredient4'].'"';
                                }   
                                if(!empty($_POST['ing4'])){
                                        echo 'value="'.$_POST['ing4'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing5"
                                <?php 
                                if(!empty($data['field_ingredient5'])&& empty($_POST['ing5'])){
                                        echo 'value="'.$data['field_ingredient5'].'"';
                                }   
                                if(!empty($_POST['ing5'])){
                                        echo 'value="'.$_POST['ing5'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing6" <?php 
                                if(!empty($data['field_ingredient6'])&& empty($_POST['ing6'])){
                                        echo 'value="'.$data['field_ingredient6'].'"';
                                }   
                                if(!empty($_POST['ing6'])){
                                        echo 'value="'.$_POST['ing6'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing7" <?php 
                                if(!empty($data['field_ingredient7'])&& empty($_POST['ing7'])){
                                        echo 'value="'.$data['field_ingredient7'].'"';
                                }   
                                if(!empty($_POST['ing7'])){
                                        echo 'value="'.$_POST['ing7'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing8"
                                <?php 
                                if(!empty($data['field_ingredient8'])&& empty($_POST['ing8'])){
                                        echo 'value="'.$data['field_ingredient8'].'"';
                                }   
                                if(!empty($_POST['ing8'])){
                                        echo 'value="'.$_POST['ing8'].'"';
                                } 
                                ?>>  
                                <input type="text" class="form-input ing" name="ing9" 
                                <?php 
                                if(!empty($data['field_ingredient9'])&& empty($_POST['ing9'])){
                                        echo 'value="'.$data['field_ingredient9'].'"';
                                }   
                                if(!empty($_POST['ing9'])){
                                        echo 'value="'.$_POST['ing9'].'"';
                                } 
                                ?>>  
                    </div>
                    <div class="steps">
                        <legend> Etapes de votre recette : </legend>
                        <?php if (isset($return_form['errors']['step'])) { ?>
                        <div class="return_error">
                            <?php echo $return_form['errors']['step']; ?>
                        </div>
                        <?php } ?>
                        <textarea name="step1" id="steps" cols="30" rows="4" >
                            <?php 
                            if(!empty($data['step1'])&& empty($_POST['step1'])){
                                echo br2nl($data['step1']);
                            }   
                            if(!empty($_POST['step1'])){
                                    echo $_POST['step1'];
                            } 
                            ?> 
                        </textarea>
                        <textarea name="step2" id="steps" cols="30" rows="4" > 
                            <?php 
                            if(!empty($data['step2'])&& empty($_POST['step2'])){
                                echo br2nl($data['step2']);
                            }   
                            if(!empty($_POST['step2'])){
                                    echo $_POST['step2'];
                            } 
                            ?>  
                        </textarea>
                        <textarea name="step3" id="steps" cols="30" rows="4">
                            <?php 
                            if(!empty($data['step3'])&& empty($_POST['step3'])){
                                echo br2nl($data['step3']);
                            }   
                            if(!empty($_POST['step3'])){
                                    echo $_POST['step3'];
                            } 
                            ?> 
                            </textarea>
                        <textarea name="step4" id="steps" cols="30" rows="4" > 
                            <?php 
                            if(!empty($data['step4'])&& empty($_POST['step4'])){
                                echo br2nl($data['step4']);
                            }   
                            if(!empty($_POST['step4'])){
                                    echo $_POST['step4'];
                            } 
                            ?>  
                        </textarea>
                        <textarea name="step5" id="steps" cols="30" rows="4" > 
                            <?php 
                            if(!empty($data['step5'])&& empty($_POST['step5'])){
                                echo br2nl($data['step5']);
                            }   
                            if(!empty($_POST['step5'])){
                                    echo $_POST['step5'];
                            } 
                            ?>  
                        </textarea>
                    </div>
                <div class="form__field">
                    <label for="picture" class="form-label" >Illustration de votre recette :</label>
                    <input type="file" id="picture" class="form-control" name="picture" accept="image/png, image/jpg, image/jpeg, image/webp">
                    <?php if(isset($return_edit['errors']['img'])){
                            foreach($return_edit['errors']['img'] as $error_img){
                                echo '<h3 class="return_error">'.$error_img.'</h3>';
                            }
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
<script src="/js/index.js"></script>
</body>

</html>


