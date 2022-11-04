<?php
session_start();
include "configuration.php";
// rends accessible la partie all recipes à tout le monde

/*if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
 if(isset($_COOKIE)){
 setcookie("PHPSESSID","",time()-3600,"/"); 
 }
 header("location:../index.php");
 exit();
 }*/

// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $current_page_nb = (int) strip_tags($_GET['page']);

} else {
    $current_page_nb = 1;
}
include "includes/function_all_recipes.php";

//filter
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
} else {
    $filter_tab['0']['empty'] = 'none';
    $filter = $filter_tab['0'];
}

//sort
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort_tab['0']['desc'] = 'desc';
    $sort = $sort_tab['0'];
}


$return = get_all_recipes($current_page_nb, $filter, $sort);

if (!isset($return['error'])) {
    $pages = $return['pages_nb'];
    $first_recipe = $return['first'];
    $recipes = $return['recipes'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "includes/include_meta_link.php"; ?>

    <title> Mon carnet de recettes - Toutes les recettes de cuisines partagées </title>

</head>

<body>
    <header>
        <?php $current_page = "all"; ?>
        <?php include "includes/navbar.php" ?>
    </header>

    <main class="bloc bg_card <?php if (isset($return['error'])) {
        echo 'smaller';
    } ?>">
        <section class="bloc">
            <h1 class="bloc__title bloc__title--bg">Toutes les recettes</h1>
            <div class="dropdown">
                <button class="dropbtn" id="dropBtn">Filtrer</button>
                <form id="filterTable" class="dropdown__filter" name="filter" method="GET" action="#">
                    <?php if (isset($filter)) {
                        foreach ($filter as $filterName) {
                            $n = 0; ?>

                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Entrées' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[entree]" value="Entrées" <?php $n++; ?>>Entrées</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Plats' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[plat]" value="Plats" <?php $n++; ?>>Plats</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Desserts' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[dessert]" value="Desserts" <?php $n++; ?>>Desserts</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Amuses bouches' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[amuse]" value="Amuses bouches" <?php $n++; ?>>Amuses bouches</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Accompagnements' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[accompagnement]" value="Accompagnements" <?php $n++; ?>>Accompagnements</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Sauces' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[sauce]" value="Sauces" <?php $n++; ?>>Sauces</button>
                    <button type="submit"
                        class="btn filter_button <?php $filterName == 'Boissons' ? $state[$n] = 'disabled' : $state[$n] = '';
                            echo $state[$n]; ?>"
                        name="filter[boisson]" value="Boissons" <?php $n++; ?>>Boissons</button>

                    <?php if ($filterName !== 'none') {
                                echo '<button type="submit" class="btn filter_button filter_button--supp" name="filter[\'none\']" value="none"> Supprimer le filtre </button>';
                            }
                        }
                    }
                        ?>
                </form>
                <button id="sortBtn" class="dropbtn" id="dropBtn">Trier</button>
                <form id="sortTable" class="dropdown__sort" name="sort" method="GET" action="#">
                    <p class="row">Trier par : </p>
                    <?php foreach ($sort as $sortValue) { ?>
                    <button type="submit" class="btn sort_button <?php echo $sortValue == "desc" ? 'disabled' : ''; ?>"
                        name="sort[desc]" value="desc" <?php echo $sortValue=="desc" ? 'disabled' : ''; ?>> Recettes les
                        plus récentes </button>
                    <button type="submit" class="btn sort_button <?php echo $sortValue == "asc" ? 'disabled' : ''; ?>"
                        name="sort[asc]" value="asc" <?php echo $sortValue=="asc" ? 'disabled' : ''; ?>> Recettes les
                        plus anciennes </button>
                    <?php } ?>
                </form>
            </div>
            <div class="bloc__body--card">

                <?php
                if (isset($return['error'])) {
                    foreach ($return['error'] as $errors => $error) {
                        echo
                            '<div class="return_error error--grid text-center">
                        <h4>' . $error . '</h4>
                    </div>';
                    }
                }
                if (isset($filter)) {
                    foreach ($filter as $filterName) {
                        if ($filterName !== 'none') {
                            echo '<h4 class="filter_name"> Catégorie : ' . $filterName . '</h4>';
                        }
                    }
                }

                if (!isset($return['error'])) {
                    $i = 0;
                    foreach ($recipes as $recipe => $array) { ?>

                <div class="card">
                    <div class="card__header">
                        <?php
                        echo '<img src="' . BASE_URL . '/Pictures/' . $array['name'] . '"  alt="image de la recette de cuisine">';
                            ?>
                    </div>
                    <div class="card__body b0">
                        <?php
                        echo '<h4 class="card__body__title">' . ucfirst($array['recipe_title']) . '</h4>';
                        ?>

                        <button class="btn--collapse btn" id="collapse_btn" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                            </svg>
                        </button>

                        <div class="bloc__collapse">
                            <?php
                        $last = substr($array['last_name'], 0, 1);
                        echo
                            '<ul class="list-group">
                                        <li class="list-group-item "> <i class="bi bi-vector-pen"></i> Auteur : ' . $array['first_name'] . '  ' . $last . '.</li>
                                        <li class="list-group-item "> <i class="bi bi-tag"></i> Catégorie : ' . $array['type'] . '</li>
                                        <li class="list-group-item"><i class="bi bi-people-fill"></i> Pour ' . $array['guest_number'] . ' personnes </li>
                                        <li class="list-group-item"> <i class="bi bi-hourglass-bottom"></i> Temps de préparation : ' . $array['setup_time'] . ' minutes </li>
                                        <li class="list-group-item">';
                        if ($array['level'] == 'faible') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Très facile';
                        }
                        if ($array['level'] == 'moyen') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Niveau moyen';
                        }
                        if ($array['level'] == 'élevé') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Difficile ';
                        }
                        echo
                            '</li>
                                        <li class="list-group-item">';
                        if ($array['price'] == 'faible') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                <i class="bi bi-circle"></i>
                                                : Bon marché';
                        }
                        if ($array['price'] == 'moyen') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle"></i>
                                                : Coût moyen';
                        }
                        if ($array['price'] == 'élevé') {
                            echo
                                '<i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                <i class="bi bi-circle-fill"></i>
                                                : Coût élevé';
                        }
                        '</li>';
                                ?>
                            </ul>
                            <div class="bloc__row">
                                <div class="card__button">
                                    <form class="noPad" action="<?php echo BASE_URL . '/recipe_extension.php' ?>"
                                        method="get" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn--extend" name="extend_btn" <?php echo
                                            'value="' . $array['recipe_id'] . '"'; ?> > <i
                                                class="bi bi-box-arrow-up-right"></i> Voir la fiche </button>
                                    </form>
                                </div>
                                <?php
                        if (isset($_SESSION['id']) || !empty($_SESSION['id']) && $_SESSION['id'] == $array['author_id']) { ?>
                                <div class="card__button">
                                    <form class="noPad" action="<?php echo BASE_URL . '/edit_recipes.php' ?>" method="get"
                                        enctype="multipart/form-data">
                                        <button class="btn btn--edit " type="submit" name="edit_btn" <?php echo
                                            'value="' . $array['recipe_id'] . '"'; ?>><i class="bi bi-pencil-fill"></i>
                                            Editer</button>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                            <?php
                        $i++;
                                ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php if (!isset($return['error']) && ($pages > 1)) { ?>
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?=($current_page_nb <= 1) ? "disabled" : "" ?>">
                    <a class="page-link" href="?page=<?= $current_page_nb - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-caret-left-square"
                                viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                <path
                                    d="M10.205 12.456A.5.5 0 0 0 10.5 12V4a.5.5 0 0 0-.832-.374l-4.5 4a.5.5 0 0 0 0 .748l4.5 4a.5.5 0 0 0 .537.082z" />
                            </svg>
                        </span>
                    </a>
                </li>
                <?php for ($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?=($current_page_nb === $page) ? "disabled" : "" ?>">
                    <a href="?page=<?= $page ?>" class="page-link--middle">
                        <?= $page ?>
                    </a>
                </li>
                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?=($current_page_nb == $pages) ? "disabled" : "" ?>">
                    <a class="page-link" href="?page=<?= $current_page_nb + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-caret-right-square"
                                viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                <path
                                    d="M5.795 12.456A.5.5 0 0 1 5.5 12V4a.5.5 0 0 1 .832-.374l4.5 4a.5.5 0 0 1 0 .748l-4.5 4a.5.5 0 0 1-.537.082z" />
                            </svg>
                        </span>
                    </a>
                </li>
            </ul>
            <?php } ?>

        </section>
    </main>
    <?php
include "includes/footer.php";
include "includes/include_script.php";
?>
</body>

</html>