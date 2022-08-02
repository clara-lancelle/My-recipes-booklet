<?php 
include "data_base.php";


const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';

function getRecipes($session_id, $current_page){

    try {
        $dbco = getConnexion();
        

        $sql = $dbco->prepare("
            SELECT COUNT(recipe_id) AS count
            FROM recipe
            WHERE author_id = :author_id"); 
        $sql -> bindParam(':author_id', $session_id);
        $sql->execute();
        $recipe_nb = $sql->fetch();

        $recipes_nb = (int) $recipe_nb['count'];

        if($recipes_nb == 0) {
            
            $error['empty'] = 'Votre carnet de recettes est vide';

        } else {

            $parPage = 8;
            $pages_nb = ceil($recipes_nb / $parPage);

            $first = ($current_page * $parPage) - $parPage;

            $sth = $dbco->prepare("
                SELECT picture.name, recipe.*, components.*, bloc_steps.*
                FROM picture 
                INNER JOIN recipe 
                ON picture.recipe_id = recipe.recipe_id 
                && recipe.author_id = :author_id
                INNER JOIN components
                ON components.fk_recipe_id = recipe.recipe_id
                INNER JOIN bloc_steps
                ON bloc_steps.fk_recipe_id = recipe.recipe_id

                ORDER BY recipe.recipe_title ASC
                LIMIT :first, :parpage
                ");

            $sth -> bindParam(':author_id', $session_id);
            $sth -> bindParam(':first',$first,PDO::PARAM_INT);
            $sth -> bindParam(':parpage',$parPage,PDO::PARAM_INT);
            $sth->execute();

            $recipes = $sth->fetchAll();
            
        }
        
    }catch(PDOException $e){
        $error['e'] = $e->getMessage();
    }

    if(isset($error)){
        return [
            'error' => $error,
        ];
        
    }
    return [
        'recipes'=>$recipes,
        'recipes_nb'=>$recipes_nb,
        'pages_nb'=>$pages_nb,
        'first'=>$first,
    ];
}


?>

