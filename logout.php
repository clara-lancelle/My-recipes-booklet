<?php
session_start();
include "configuration.php";

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    if (isset($_COOKIE)) {
        setcookie("PHPSESSID", "", time() - 3600, "/");
    }
    header("location:" . BASE_URL . "/index.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location:" . BASE_URL . "/index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "includes/include_meta_link.php"; ?>

    <title>Mon carnet de recettes - Déconnexion </title>

</head>

<body>
    <header>
        <?php $current_page = "out"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="smaller grey">

        <?php
if (!isset($_POST['logout'])) {

?>

        <section class="bloc text-center bloc--pad">
            <h1 class="pad">Voulez-vous vous déconnecter du carnet de recettes ?</h1>
            <form action="#" method="post" enctype="multipart/form-data">
                <button class="btn btn--logout" type="submit" name="logout" value="true">Me déconnecter</button>
            </form>

            <?php
} ?>
        </section>
    </main>
    <?php
include "includes/footer.php";
include "includes/include_script.php";
?>
</body>

</html>