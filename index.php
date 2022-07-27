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
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Connexion </title>

</head>

<body>
    <header>
        <?php $current_page = "log"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller index">


    <section class="ban"></section>

        <section class="bloc">

        <h2 class="bloc__title" >Connexion :</h2>
            <?php if(empty($_SESSION['id'])){ ?>

                <form action="#" name='connexion' method="post">

                    <div class="form__field">
                        <label for="email" class="form-label"> Votre email : </label>
                        <input type="email" class="form-control" id="email" name="email"
                        <?php 
                            if(!empty($_POST['email']) && isset($return['errors'])){
                                echo 'value="'.$_POST['email'].'"';
                        }?> 
                        >
                        <?php if (isset($return['errors']['email'])) { ?>
                            <div  class="return_error" >
                                <?php echo $return['errors']['email']; ?>   
                            </div>
                        <?php } ?>
                        <?php if (isset($return['errors']['invalid_email'])) { ?>
                            <div class="return_error">
                                <?php echo $return['errors']['invalid_email']; ?>   
                            </div>
                        <?php } ?>
                    </div>


                    <?php if(isset($return['errors']['invalid_count'])) {?>
                            <div class="return_error" >
                                <?php echo '!  '.$return['errors']['invalid_count'].'  !'; ?>   
                            </div>
                        <?php }?>
                        <?php if(isset($return['errors']['invalid_hash'])) {?>
                            <div class="return_error" >
                                <?php echo '!  '.$return['errors']['invalid_hash'].'  !'; ?>   
                            </div>
                        <?php }?>

                    <div class="form__field">
                        <label for="password" class="form-label"> Mot de passe : </label>
                        <input type="password" class="form-control" id="password" name="password">
                        <?php if (isset($return['errors']['password'])) { ?>
                            <div class="return_error" >
                                <?php echo $return['errors']['password']; ?>   
                            </div>
                        <?php } ?>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn--log" >Me connecter</button>
                    </div>
                </form>                   
                            
                <?php }else{ ?>

                    <div class="connect text-center bigger">

                        <h3> Vous êtes connecté(e) ! </h3>

                        <?php header("location: all_recipes.php");
                        die(); ?>

                    </div>
                <?php }?>
            </section>
    </main>
<?php include "includes/footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/index.js"></script>
</body>

</html>
