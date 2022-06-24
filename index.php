<?php 
session_start();
include "includes/function_login.php";

if(!empty($_POST)){
    $return = fct_connexion($_POST);
    
    if(isset($return['id'])){
    $_SESSION['id'] = $return['id']['user_id'];
    }
}


?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">
  
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_login.css">

  <title>Mes recettes - Connexion </title>

</head>

<body>
    <header>
        <?php $current_page = "log"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

<div class="container-fluid justify-content-center py-5 w-100 col-12" >

<div class="col col-sm-8 col-lg-6 justify-self-center m-lg-auto m-auto pb-5">

<h2 class="pt-5 pb-2 text-secondary" >Connexion :</h2>
    <?php if(empty($_SESSION['id'])){ ?>

        <div class="row col-12 justify-content-center  py-5 ">

            <form action="#" name='connexion' method="post">

                
                <div class="col-10 justify-self-center m-auto py-4">
                    <label for="email" class="form-label"> Votre email : </label>
                    <input type="email" class="form-control" id="email" name="email"
                    <?php 
                        if(!empty($_POST['email']) && isset($return['errors'])){
                            echo 'value="'.$_POST['email'].'"';
                    }?> 
                    >
                    <?php if (isset($return['errors']['email'])) { ?>
                        <div  class="alert pt-2" >
                            <?php echo $return['errors']['email']; ?>   
                        </div>
                    <?php } ?>
                    <?php if (isset($return['errors']['invalid_email'])) { ?>
                        <div class="alert pt-2">
                            <?php echo $return['errors']['invalid_email']; ?>   
                        </div>
                    <?php } ?>
                </div>


                <?php if(isset($return['errors']['invalid_count'])) {?>
                        <div class="alert m-auto text-center p-3" >
                            <?php echo '!  '.$return['errors']['invalid_count'].'  !'; ?>   
                        </div>
                    <?php }?>
                    <?php if(isset($return['errors']['invalid_hash'])) {?>
                        <div class="alert m-auto text-center p-3" >
                            <?php echo '!  '.$return['errors']['invalid_hash'].'  !'; ?>   
                        </div>
                    <?php }?>

                <div class="col-10 justify-self-center m-auto py-4">
                    <label for="password" class="form-label"> Mot de passe : </label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php if (isset($return['errors']['password'])) { ?>
                        <div class="alert pt-2" >
                            <?php echo $return['errors']['password']; ?>   
                        </div>
                    <?php } ?>
                </div>
                <div class="col-6 m-auto py-5">
                    <button type="submit" class="btn w-100" >Me connecter</button>
                </div>
            </form>
        </div>
    </div>
                    
    <?php }else{ ?>

    <div class="already_connect">

        <h3> Vous êtes connecté(e) ! </h3>

        <?php header("location: all_recipes.php");
        die(); ?>

    </div>
    <?php }?>
    
</div>
<?php include "includes/footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
