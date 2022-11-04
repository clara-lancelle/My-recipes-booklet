<?php
session_start();
include "configuration.php";

include "includes/function_password_recovery.php";


if (isset($return['id'])) {
    $_SESSION['id'] = $return['id']['user_id'];
}

if (!empty($_SESSION['id']) && ($_SESSION['id'] !== null)) {
    header("location: " . BASE_URL . "/all_recipes.php");
    die();

} elseif (empty($_POST['postEmail'])) {

} else {
    $email = $_POST['postEmail'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "includes/include_meta_link.php"; ?>

    <title>Mon carnet de recettes - Récupération de mot de passe </title>

</head>

<body>
    <header>
        <?php $current_page = ""; ?>
        <?php include "includes/navbar.php" ?>
    </header>
    <main class="smaller">
        <section class="bloc bloc--pad">
            <h1 class="bloc__title">Récupération de votre mot de passe :</h1>
            <form class="form--bg" action="#" id="recoveryForm" name='recoveryForm' method="post">
                <div class="form__field form__field--90">
                    <label for="email" class="form-label"> Afin de pouvoir vous reconnecter, merci de confirmer votre
                        email : </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="<?= $email ?>">
                </div>
                <button type="submit" class="btn btn--recover"> Envoyer le nouveau mot de passe </button>
            </form>
        </section>
    </main>
</body>

</html>

<?php }
/* if (isset($return['errors']['email'])) { ?>
 <div  class="return_error" >
 <?php echo $return['errors']['email']; ?>   
 </div>
 <?php } ?>
 <?php if (isset($return['errors']['invalid_email'])) { ?>
 <div class="return_error">
 <?php echo $return['errors']['invalid_email']; ?>   
 </div>
 <?php } */?>