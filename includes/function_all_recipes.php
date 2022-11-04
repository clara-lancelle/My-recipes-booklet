<?php
include "./data_base.php";

function get_all_recipes($current_page, $filter, $sort)
{

    $filters = array(

        "none" => "",
        "Entrées" => "WHERE recipe.type LIKE 'Entrées'",
        "Plats" => "WHERE recipe.type = 'Plats'",
        "Desserts" => "WHERE recipe.type = 'Desserts'",
        "Amuses bouches" => "WHERE recipe.type = 'Amuses bouches'",
        "Accompagnements" => "WHERE recipe.type = 'Accompagnements'",
        "Sauces" => "WHERE recipe.type = 'Sauces'",
        "Boissons" => "WHERE recipe.type = 'Boissons'",


    );

    $sorts = array(
        "desc" => "ORDER BY recipe.date_time DESC",
        "asc" => "ORDER BY recipe.date_time ASC",
    );

    foreach ($filter as $filterSql) {

        try {
            $dbco = getConnexion();

            $sql = $dbco->prepare("
                SELECT COUNT(*) AS recipe_nb 
                FROM recipe
                $filters[$filterSql]
                ");

<<<<<<< HEAD
            $sql->execute();
            $result = $sql->fetch();

            $recipes_nb = (int)$result['recipe_nb'];

            if ($recipes_nb == 0) {

                $error['empty'] = 'Oups.. Aucune recette n\'a été trouvée';
=======
function get_all_recipes($current_page, $filter){

    $filters = array(

        "none" => "",
        "1" => "WHERE recipe.type LIKE 'Entrées'",
        "2" => "WHERE recipe.type = 'Plats'",
        "3" => "WHERE recipe.type = 'Desserts'",
        "4" => "WHERE recipe.type = 'Amuses bouches'",
        "5" => "WHERE recipe.type = 'Accompagnements'",
        "6" => "WHERE recipe.type = 'Sauces'",
        "7" => "WHERE recipe.type = 'Boissons'",
        
    );

    foreach($filter as $filterName) {
        
    
    
        try {
            $dbco = getConnexion();
        
            $sql = $dbco->prepare("
                SELECT COUNT(*) AS recipe_nb 
                FROM recipe
                $filters[$filterName]
                ");

                $sql->execute();
                $result= $sql->fetch();
                
            $recipes_nb = (int) $result['recipe_nb'];

            $parPage = 8;
            $pages_nb = ceil($recipes_nb / $parPage);

            $first = ($current_page * $parPage) - $parPage;
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355

            } else {

<<<<<<< HEAD
                $parPage = 8;
                $pages_nb = ceil($recipes_nb / $parPage);

                $first = ($current_page * $parPage) - $parPage;

                foreach ($sort as $sortSql) {

                    $sth = $dbco->prepare("
                    SELECT picture.*, recipe.*, user.*
                    FROM picture 
                    INNER JOIN recipe 
                    ON recipe.recipe_id = picture.recipe_id
                    INNER JOIN user 
                    ON user.user_id = recipe.author_id
                    $filters[$filterSql]
                    $sorts[$sortSql]
                    LIMIT :first, :parpage
                    ");
                    $sth->bindParam(':first', $first, PDO::PARAM_INT);
                    $sth->bindParam(':parpage', $parPage, PDO::PARAM_INT);
                    $sth->execute();

                    $recipes = $sth->fetchAll();
                }

            }

        } catch (PDOException $e) {
=======
            $sth = $dbco->prepare("
                SELECT picture.*, recipe.*
                FROM picture 
                INNER JOIN recipe ON recipe.recipe_id = picture.recipe_id
                $filters[$filterName]
                ORDER BY recipe.recipe_title ASC
                LIMIT :first, :parpage
                "); 
                $sth -> bindParam(':first',$first,PDO::PARAM_INT);
                $sth -> bindParam(':parpage',$parPage,PDO::PARAM_INT);
                $sth->execute();

                $recipes = $sth->fetchAll();
            

        }catch(PDOException $e){
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
            $e->getMessage();
        }
    }

    if (isset($error)) {
        return [
            'error' => $error,
        ];
    }

    return [
        'recipes' => $recipes,
        'recipes_nb' => $recipes_nb,
        'pages_nb' => $pages_nb,
        'first' => $first,
    ];

}

/*
$filters = array(

<<<<<<< HEAD
=======
    "none" => "ORDER BY recipe.recipe_title ASC",
    "entree" => "ON recipe.ype = 'Entrées'",
    "plat" => "ON recipe.type = 'Plats'",
    "dessert" => "ON recipe.type = 'Desserts'",
    "amuse" => "ON recipe.type = 'Amuses bouches'",
    "accompagnement" => "ON recipe.type = 'Accompagnements'",
    "sauce" => "ON recipe.type = 'Sauces'",
    'boisson' => "ON recipe.type = 'Boissons'",
    
);

foreach((array_keys($filter)) as $filterName) {
    return $filterName;
}
 var_dump($filterName);*/
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
?>