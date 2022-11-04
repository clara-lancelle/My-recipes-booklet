<?php 
session_start();
<<<<<<< HEAD
include "configuration.php";
=======
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

include "includes/function_inscription.php";

if(!empty($_POST)){
    $return = fct_inscription($_POST);
}    
if(isset($return['id'])){
$_SESSION['id'] = $return['id']['user_id'];
}
if(!empty($_SESSION['id'])){
<<<<<<< HEAD
    header("location: ".BASE_URL."/my_recipes.php");
=======
    header("location: my_recipes.php");
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
die();
    
}else{


?>

<!DOCTYPE html>
<html lang="en"> 
<head>
<<<<<<< HEAD


  <?php include "includes/include_meta_link.php"; ?>>
=======
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
  
  <title>Mon carnet de recettes - Inscription </title>

</head>

<body>
    <header>
        <?php $current_page = "ins"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller ins small-top">
        <section class="bloc ins">

<<<<<<< HEAD
            <h1 class="bloc__title"> Inscription : </h1>
=======
            <h2 class="bloc__title"> Inscription : </h2>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

                <form  class="form--bg" action="#" name='inscription' method="post">

                <?php if (isset($return['errors']['db'])) { ?>
                    <div class="return_error">
                        <?php echo $return['errors']['db']; ?>   
                    </div>
                <?php } ?>

                <?php if (isset($return['errors']['empty'])) { ?>
                    <div class="return_error">
                        <?php echo $return['errors']['empty']; ?>   
                    </div>
                <?php } ?>
                    
                <div class="form__field form__field--90">
                    <label for="lastname" class="form-label"> Votre nom : </label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                    <?php 
                        if(!empty($_POST['lastname']) && isset($return['errors'])){
                            echo 'value="'.$_POST['lastname'].'"';
                    }?> 
                    >
                    <?php if (isset($return['errors']['last'])) { ?>
                        <div class="return_error">
                            <?php echo $return['errors']['last']; ?>   
                        </div>
                    <?php } ?>
                </div>

                <div class="form__field form__field--90">
                    <label for="firstname" class="form-label"> Votre prénom : </label>
                    <input type="text" class="form-control" id="firstname" name="firstname" 
                    <?php 
                        if(!empty($_POST['firstname']) && isset($return['errors'])){
                            echo 'value="'.$_POST['firstname'].'"';
                    }?> 
                    >
                    <?php if (isset($return['errors']['first'])) { ?>
                        <div class="return_error">
                            <?php echo $return['errors']['first'];?>   
                            
                        </div>
                    <?php } ?>
                </div>

                <div class="form__field form__field--90">
                    <label for="email" class="form-label"> Votre email : </label>
                    <input type="email" class="form-control" id="email" name="email"
                    <?php 
                        if(!empty($_POST['email']) && isset($return['errors'])){
                            echo 'value="'.$_POST['email'].'"';
                    }?> 
                    >
                    <?php if (isset($return['errors']['email'])) { ?>
                        <div class="return_error">
                            <?php echo $return['errors']['email']; ?>   
                        </div>
                    <?php } ?>
                    <?php if (isset($return['errors']['same'])) { ?>
                        <div class="return_error">
                            <?php echo $return['errors']['same']; ?>   
                        </div>
                    <?php } ?>
                </div>

                <div class="form__field form__field--90">
                    <label for="password" class="form-label"> Mot de passe : </label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form__field form__field--90">
                    <label for="confirm_password" class="form-label"> Confirmer votre mot de passe : </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <?php if (isset($return['errors']['confirm'])) { ?>
                        <div class="return_error">
                            <?php echo $return['errors']['confirm']; ?>   
                        </div>
                    <?php } ?>
                </div>

                <div class="text-center pad">
                    <button type="submit" class="btn btn--ins">M'inscrire</button>
                </div>
            </form>
            <?php } ?>
        </section>
    </main>
<<<<<<< HEAD
<?php 
include  "includes/footer.php"; 
include "includes/include_script.php";
?> 
=======
<?php include "includes/footer.php"; ?> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/index.js"></script>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
</body>

</html>
