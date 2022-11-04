<?php
session_start();
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


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "includes/include_meta_link.php"; ?>

    <title>Mon carnet de recettes - Connexion </title>

</head>

<body>
    <header>
        <?php $current_page = "log"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller index small-top">
        <section class="bloc bloc--index">

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
                    <?php } ?>
                </div>


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

                <div class="form__field form__field--90">
                    <label for="password" class="form-label"> Mot de passe : </label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php if (isset($return['errors']['password'])) { ?>
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
        </section>
    </main>
    <?php
    include "includes/footer.php";
    include "includes/include_script.php";
?>
</body>

</html>
<?php } ?>