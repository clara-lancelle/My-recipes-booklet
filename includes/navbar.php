
<div class="navbar">
        <figure class="navbar__logo">
            <a id="home_link" href="#"><img class="logo" src="http://localhost/TD_RECIPES/includes/img/logo-w.png" alt="logo"></a>
        </figure>

        <div class="navbar__brand">
            <h1>My Recipes Booklet</h1>
        </div>

        <div id="menu-button">
            <div id="line-1"></div>
            <div id="line-2"></div>
            <div id="line-3"></div>
        </div>

        <nav class="navbar__items" role="navigation" id="menu">
            <ul>
                <?php
                    if(empty($_SESSION['id'])){ 
                ?>
                    <li class="navbar__items__link">
                        <a <?php echo $current_page == "log" ? 'class="page__link active"' : 'class="page__link"' ;?> href="http://localhost/TD_RECIPES/index.php" >Me connecter</a>
                    </li>
                    <li class="navbar__items__link">
                        <a <?php echo $current_page == "ins" ? 'class="page__link active"': 'class="page__link"' ;?> href="http://localhost/TD_RECIPES/inscription.php" >M'inscire</a>
                    </li>
                <?php } ?>
                <?php
                    if(!empty($_SESSION['id'])){ 
                ?>
                    <li class="navbar__items__link"> 
                        <a <?php echo $current_page == "my" ? 'class="page__link active"': 'class="page__link"' ;?> href="http://localhost/TD_RECIPES/my_recipes.php">Mes recettes</a>    
                    </li>
                    <li class="navbar__items__link"> 
                        <a <?php echo $current_page == "all" ? 'class="page__link active" ': 'class="page__link"' ;?> href="http://localhost/TD_RECIPES/all_recipes.php/?page=1">Toutes les recettes</a> 
                    </li>
                    <li class="navbar__items__link"> 
                        <a <?php echo $current_page == "add" ? 'class="page__link active" ': 'class="page__link"' ;?>  href="http://localhost/TD_RECIPES/add_recipe.php">Ajouter une recette</a> 
                    </li>
                    <li class="navbar__items__link"> 
                        <a <?php echo $current_page == "out" ? 'class="page__link active"': 'class="page__link"' ;?> href="http://localhost/TD_RECIPES/logout.php" >Me déconnecter</a>
                    </li>
                <?php }?>  
            </ul>
        </nav> 
    </div>
        