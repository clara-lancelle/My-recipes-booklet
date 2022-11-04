<?php
session_start();
<<<<<<< HEAD
include "configuration.php";

include "includes/function_login.php";

if (!empty($_POST)) {
    $return = fct_connexion($_POST);
}
if (isset($return['id'])) {
    $_SESSION['id'] = $return['id']['user_id'];
}
if (!empty($_SESSION['id']) && ($_SESSION['id'] !== null)) {
    header("location: " . BASE_URL . "/all_recipes.php");
    die();

} else {
=======
   
include "includes/function_login.php";
if(!empty($_POST)){
    $return = fct_connexion($_POST);
}    
if(isset($return['id'])){
    $_SESSION['id'] = $return['id']['user_id'];
}
if(!empty($_SESSION['id'])){
    header("location: all_recipes.php");
die();
    
}else{
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355


?>

<!DOCTYPE html>
<html lang="en">

<head>
<<<<<<< HEAD

    <?php include "includes/include_meta_link.php"; ?>

    <title>Mon carnet de recettes - Connexion </title>
=======
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/includes/img/favicon.png" type="image/png">
  <Link href="style.css" rel="stylesheet" type="text/css" />
  
  <title>Mes recettes - Connexion </title>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

</head>

<body>
    <header>
        <?php $current_page = "log"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller index small-top">
        <section class="bloc bloc--index">

<<<<<<< HEAD
            <h1 class="bloc__title">Connexion :</h1>

            <form class="form--bg" action="#" name='connexion' method="post">

                <div class="form__field form__field--90">
                    <label for="email" class="form-label"> Votre email : </label>
                    <input type="email" class="form-control" id="email" name="email" <?php if (!empty($_POST['email'])
        && isset($return['errors'])) { echo 'value="' . $_POST['email'] . '"'; } ?>
                    >
                    <?php if (isset($return['errors']['email'])) { ?>
                    <div class="return_error">
                        <?php echo $return['errors']['email']; ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($return['errors']['invalid_email'])) { ?>
                    <div class="return_error">
                        <?php echo $return['errors']['invalid_email']; ?>
                    </div>
=======
        <h2 class="bloc__title" >Connexion :</h2>

            <form  class="form--bg" action="#" name='connexion' method="post">

                <div class="form__field form__field--90">
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
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                    <?php } ?>
                </div>


<<<<<<< HEAD
                <?php if (isset($return['errors']['invalid_count'])) { ?>
                <div class="return_error">
                    <?php echo '!  ' . $return['errors']['invalid_count'] . '  !'; ?>
                </div>
                <?php } ?>
                <?php if (isset($return['errors']['invalid_hash'])) { ?>
                <div class="return_error">
                    <?php echo '!  ' . $return['errors']['invalid_hash'] . '  !'; ?>
                </div>
                <?php } ?>
=======
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
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

                <div class="form__field form__field--90">
                    <label for="password" class="form-label"> Mot de passe : </label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php if (isset($return['errors']['password'])) { ?>
<<<<<<< HEAD
                    <div class="return_error">
                        <?php echo $return['errors']['password']; ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn--log">Me connecter</button>
                </div>
            </form>
            <?php if (!isset($return['errors']['invalid_email']) && !empty($_POST['email']) && !empty($_POST['password']) && (isset($return['errors']['invalid_count']) || isset($return['errors']['invalid_hash']))) { ?>
            <form class="form-bg" action="<?php echo BASE_URL . '/password_recovery.php'; ?>" method="post"
                name="forgotten_pass" id="forgottenPass">
                <input type="hidden" name="postEmail" value="<?= $_POST['email']; ?>">
                <button type="submit" id="forgottenPassBtn" class="btn btn--forgotten_pass"> Mot de passe oublié
                </button>
            </form>
            <?php die();
    } ?>
=======
                        <div class="return_error" >
                            <?php echo $return['errors']['password']; ?>   
                        </div>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn--log" >Me connecter</button>
                </div>
            </form>                          
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
        </section>
    </main>
    <?php
    include "includes/footer.php";
    include "includes/include_script.php";
?>
</body>
</html>
<<<<<<< HEAD
<?php } ?>
=======
<?php } ?>
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
