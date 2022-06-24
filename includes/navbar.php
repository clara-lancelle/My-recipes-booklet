

<nav class="navbar navbar-expand-lg navbar-dark sticky-top px-5 bg-secondary">
    <a class="navbar-brand" href="#">
    <img src="http://localhost/TD_RECIPES/includes/img/logo.png" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto mx-lg-5">
    <?php
        if(empty($_SESSION['id'])){ 
    ?>
        <li class="nav-item px-lg-5 ">
            <a class="nav-link"  <?php echo $current_page == "log" ? ' style="text-decoration: none; color:white;" ' : 'style="text-decoration: none;"' ;?> href="http://localhost/TD_RECIPES/index.php" >Me connecter</a>
        </li>
        <li class="nav-item px-lg-5 ">
            <a class="nav-link"  <?php echo $current_page == "ins" ? 'style="text-decoration: none;color:white;" ': 'style=" text-decoration: none;"' ;?> href="http://localhost/TD_RECIPES/inscription.php" >M'inscire</a>
        </li>
      <?php } ?>
    <?php
        if(!empty($_SESSION['id'])){ 
    ?>
        <li class="nav-item px-lg-5">
            <a class="nav-link" <?php echo $current_page == "my" ? 'style=" text-decoration: none;color:white;" ': 'style="text-decoration: none;"' ;?> href="http://localhost/TD_RECIPES/my_recipes.php">Mes recettes</a>
        </li>
        <li class="nav-item px-lg-5">
            <a class="nav-link" <?php echo $current_page == "all" ? 'style=" text-decoration: none;color:white;" ': 'style="text-decoration: none;"' ;?> href="http://localhost/TD_RECIPES/all_recipes.php/?page=1">Toutes les recettes</a> 
        </li>
        <li class="nav-item px-lg-5">
            <a class="nav-link" <?php echo $current_page == "add" ? 'style=" text-decoration: none;color:white;" ': 'style="text-decoration: none;"' ;?>  href="http://localhost/TD_RECIPES/add_recipe.php">Ajouter une recette</a>    
        </li>
        <li class="nav-item px-lg-5">
            <a class="nav-link"  <?php echo $current_page == "out" ? 'style=" text-decoration:none;color:white;" ': 'style="text-decoration: none;"' ;?> href="http://localhost/TD_RECIPES/logout.php" >Me déconnecter</a>
        </li>
      <?php }?>
    </ul>
  </div>
</nav>
