<?php 
session_start();
include "includes/function_inscription.php";

if(!empty($_POST)){
    $return = fct_inscription($_POST);
    
    if(isset($return['id'])){
    $_SESSION['id'] = $return['id']['user_id'];
    }
}

?>

<!DOCTYPE html>
<html lang="en"> 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="http://localhost/TD_RECIPES/includes/img/favicon.png" type="image/png">
  
  <link
  rel="stylesheet"
  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
  crossorigin="anonymous"
  >
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/nav_foot.css">
  <link rel="stylesheet" href="http://localhost/TD_RECIPES/includes/style/s_inscription.css">
  
  <title>Mes recettes - Inscription </title>

</head>

<body>
    <header>
        <?php $current_page = "ins"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

<div class="container-fluide justify-content-center text-center">

<div class="col col-10 col-xl-6 justify-self-center m-lg-auto m-auto pb-5">

    <h2 class="pt-5 pb-2 text-secondary"> Inscription : </h2>
    <div class="row py-5 justify-content-center m-auto " >

    <?php if(empty($_SESSION['id'])){ ?>

        <form action="#" name='inscription' method="post">

        <?php if (isset($return['errors']['db'])) { ?>
            <div class="error">
                <?php echo $return['errors']['db']; ?>   
            </div>
        <?php } ?>

        <?php if (isset($return['errors']['empty'])) { ?>
            <div class="alert">
                <?php echo $return['errors']['empty']; ?>   
            </div>
        <?php } ?>
            
        <div class="col-10 justify-self-center m-auto py-4">
            <label for="lastname" class="form-label"> Votre nom : </label>
            <input type="text" class="form-control" id="lastname" name="lastname"
            <?php 
                if(!empty($_POST['lastname']) && isset($return['errors'])){
                    echo 'value="'.$_POST['lastname'].'"';
            }?> 
            >
            <?php if (isset($return['errors']['last'])) { ?>
                <div class="error">
                    <?php echo $return['errors']['last']; ?>   
                </div>
            <?php } ?>
        </div>

        <div class="col-10 justify-self-center m-auto py-4">
            <label for="firstname" class="form-label"> Votre prénom : </label>
            <input type="text" class="form-control" id="firstname" name="firstname" 
            <?php 
                if(!empty($_POST['firstname']) && isset($return['errors'])){
                    echo 'value="'.$_POST['firstname'].'"';
            }?> 
            >
            <?php if (isset($return['errors']['first'])) { ?>
                <div class="error">
                    <?php echo $return['errors']['first'];?>   
                    
                </div>
            <?php } ?>
        </div>

        <div class="col-10 justify-self-center m-auto py-4">
            <label for="email" class="form-label"> Votre email : </label>
            <input type="email" class="form-control" id="email" name="email"
            <?php 
                if(!empty($_POST['email']) && isset($return['errors'])){
                    echo 'value="'.$_POST['email'].'"';
            }?> 
            >
            <?php if (isset($return['errors']['email'])) { ?>
                <div class="error">
                    <?php echo $return['errors']['email']; ?>   
                </div>
            <?php } ?>
            <?php if (isset($return['errors']['same'])) { ?>
                <div class="error">
                    <?php echo $return['errors']['same']; ?>   
                </div>
            <?php } ?>
        </div>

        <div class="col-10 justify-self-center m-auto py-4">
            <label for="password" class="form-label"> Mot de passe : </label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="col-10 justify-self-center m-auto py-4">
            <label for="confirm_password" class="form-label"> Confirmer votre mot de passe : </label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            <?php if (isset($return['errors']['confirm'])) { ?>
                <div class="error">
                    <?php echo $return['errors']['confirm']; ?>   
                </div>
            <?php } ?>
        </div>

        <div class="col-6 m-auto py-5">
            <button type="submit" class="btn w-100">M'inscrire</button>
        </div>
        </form>
    </div>
</div>
<?php } ?>

    <?php if(!empty($_SESSION['id'])){ ?>
        <div class="already_connect">

            <h4>Vous êtes inscrit(e), bienvenue !</h4>

        </div>
    <?php die(); } ?>
    
</div>
<?php include "includes/footer.php"; ?> 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
