<?php 
include "data_base.php";

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
            $e->getMessage();
        }
    }

    if(isset($e)){
        return $e ;
    }

    return [
        'recipes'=>$recipes,
        'recipes_nb'=>$recipes_nb,
        'pages_nb'=>$pages_nb,
        'first'=>$first,
    ];
       
}

/*
$filters = array(

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
?>