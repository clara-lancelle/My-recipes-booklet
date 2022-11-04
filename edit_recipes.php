<?php
session_start(); 
include "configuration.php";

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    if(isset($_COOKIE)){
        setcookie("PHPSESSID","",time()-3600,"/"); 
    }
   header("location:".BASE_URL."/index.php");
   exit();
}

if(!isset($_GET['edit_btn']) || empty( $_GET['edit_btn'])){
    header("location:".BASE_URL."/all_recipes.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
  <!-- Required meta tags -->
  <?php include "includes/include_meta_link.php"; ?>
  
  <title>Mon carnet de recettes - Edition de ma recette </title>


</head>

<body>
    <header>
        <?php 
        $current_page = 'edit';
        include "includes/navbar.php" ?>
    </header>

    <main class="edit_main">

        <section class="bloc">

        <h1 class="bloc__title">Editer ma recette</h1>
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
                    if(isset($return_edit['message'])){?>
                    <div class="success">
                        <h3 id="success_message" class="return_message"><?=$return_edit['message']?></h3>
                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                        </svg>
                    </div>
                   <?php } ?>
                
                
            <form id="form" class="form--bg" action="#" name='form' method="post" enctype="multipart/form-data">

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
                    <select name="cat" id="cat" class="form-control">

                    <?php   if(!empty($data['type'])&& empty($_POST['cat'])){
                                    $cat = $data['type'];    
                            }
                            if(!empty($_POST['cat'])){
                                $cat = $_POST['cat'];          
                        } 
                        ?>
                        <option value="Entrées"><?php echo $cat;?></option>
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
                        name="level" value="faible" <?php if(!empty($_POST['level']) && $_POST['level']=='faible'){echo "checked";}
                        if(!empty($data['level']) && $data['level']=='faible' && empty($_POST['level'])){ echo "checked";} ?> >
                        <label for="weak" class="form-check-label pr-4">Faible</label>
                    
                        <input type="radio" class="form-check-input" id="medium"
                        name="level" value="moyen" <?php if(!empty($_POST['level']) && $_POST['level']=='moyen'){echo 'checked';}
                        if(!empty($data['level']) && $data['level']=='moyen' && empty($_POST['level'])){ echo 'checked';} ?> >
                        <label for="medium" class="form-check-label pr-4">Moyen</label>
                    
                        <input type="radio" class="form-check-input" id="strong"
                        name="level" value="élevé"
                        <?php if(!empty($_POST['level']) && $_POST['level']=='élevé'){echo 'checked';}
                            if(!empty($data['level']) && $data['level']=='élevé' && empty($_POST['level'])){echo 'checked';} ?>>
                        <label for="strong" class="form-check-label">Elevé</label>
                </div>   
                <div class="form__field--radio">
                    <?php if(isset($return_edit['errors']['rado_price'])){
                        echo '<h3 class="return_error">'.$return_edit['errors']['radio_price'].'</h3>';
                        }?>
                    <p class="form-label--radio"> Coût des ingrédients :</p>

                        
                    <input class="form-check-input" type="radio"  id="faible"
                        name="price" value="faible"<?php if(!empty($_POST['price']) && $_POST['price']=='faible'){echo 'checked';}
                            if(!empty($data['price']) && $data['price']=='faible' && empty($_POST['price'])){ echo 'checked';} ?> >
                    <label for="faible" class="form-check-label">Faible</label>
                    <input type="radio" class="form-check-input" id="moyen"
                        name="price" value="moyen"<?php if(!empty($_POST['price']) && $_POST['price']=='moyen'){echo 'checked';}
                            if(!empty($data['price']) && $data['price']=='moyen' && empty($_POST['price'])){echo 'checked';} ?> >
                    <label for="moyen" class="form-check-label">Moyen</label>

                    <input type="radio" class="form-check-input" id="eleve"
                        name="price" value="élevé"<?php if(!empty($_POST['price']) && $_POST['price']=='élevé'){echo 'checked';}
                            if(!empty($data['price']) && $data['price']=='élevé' && empty($_POST['price'])){ echo 'checked';} ?> >
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
                        
                            <?php 
                            if(!empty($data['step1'])&& empty($_POST['step1'])){
                                $valeur1 =  trim($data['step1']);
                            }   
                            if(!empty($_POST['step1'])){
                                   $valeur1 = trim($_POST['step1']);
                            } 
                            
                            ?>
                        <textarea name="step1" id="steps" cols="30" rows="4"><?= $valeur1 ?></textarea>
                        
                        <?php 
                            if(!empty($data['step2'])&& empty($_POST['step2'])){
                                $valeur2 =  br2nl(trim($data['step2']));
                            }elseif(!empty($_POST['step2'])){
                                   $valeur2 = trim($_POST['step2']);
                            }else{
                                $valeur2 = '';
                            }
                            
                            ?>
                        <textarea name="step2" id="steps" cols="30" rows="4"><?= $valeur2 ?></textarea>
                        
                            <?php 
                            if(!empty($data['step3'])&& empty($_POST['step3'])){
                                $valeur3 = br2nl($data['step3']);
                            }elseif(!empty($_POST['step3'])){
                                $valeur3 = trim($_POST['step2']);
                            }else{
                                $valeur3 ='.';
                            }
                            ?> 
                        <textarea name="step3" id="steps" cols="30" rows="4"><?= $valeur3 ?></textarea>
                        
                            <?php 
                            if(!empty($data['step4'])&& empty($_POST['step4'])){
                                $valeur4 = br2nl($data['step4']);
                            }elseif(!empty($_POST['step4'])){
                                    $valeur4 = trim($_POST['step4']);
                            }else{
                                $valeur4 = '.';
                            }
                            ?>  
                       <textarea name="step4" id="steps" cols="30" rows="4"><?= $valeur4 ?></textarea>
                        
                       <?php 
                            if(!empty($data['step5'])&& empty($_POST['step5'])){
                                $valeur5 = br2nl($data['step5']);
                            }elseif(!empty($_POST['step5'])){
                                    $valeur5 = trim($_POST['step5']);
                            }else{
                                $valeur5 = '.';
                            }
                            ?>  
                       <textarea name="step5" id="steps" cols="30" rows="4"><?= $valeur5 ?></textarea>

                    </div>
                <div class="form__field form__field__img">
                    <label for="picture" class="form-label" >Illustration de votre recette :</label>
                                <?php 
                                if(isset($return_edit['temporary_file'])&& !empty($return_edit['temporary_file'])){
                                    $current_pic_path = BASE_URL.'/Pictures/tmp/'.$return_edit['temporary_file'];
                                    $picToEdit = $return_edit['temporary_file'];
                                }else{
                                    $current_pic_path = BASE_URL.'/Pictures/'.$data['name'];
                                    $picToEdit = 'false';
                                }                                                                                                                                                                                                                                                                           
                                ?>
                                <img class="picToEdit" src="<?php echo $current_pic_path;?>" alt="votre image"/>
                            <input type="hidden" name="picToEdit" value="<?=$picToEdit?>"/>
                            
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
<?php 
    include "includes/footer.php"; 
    include "includes/include_script.php";
        ?>

</body>

</html>


