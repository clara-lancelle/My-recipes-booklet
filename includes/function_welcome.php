<?php 
include "data_base.php";

function get_recent_recipes(){

try {
            $dbco = getConnexion();
        
            $sql = $dbco->prepare("
                SELECT COUNT(*) AS recipe_nb 
                FROM recipe
                ");

                $sql->execute();
                $result= $sql->fetch();
                
            $recipes_nb = (int) $result['recipe_nb'];

            if($recipes_nb == 0) {
                
                $error['empty'] = 'Oups.. Aucune recette n\'a été trouvée';

            } else {


            $sth = $dbco->prepare("
                SELECT picture.*, recipe.*, user.*
                FROM picture 
                INNER JOIN recipe ON recipe.recipe_id = picture.recipe_id
                INNER JOIN user ON user.user_id = recipe.author_id
                ORDER BY recipe.date_time DESC
                LIMIT 3
                "); 
                $sth->execute();

                $recipes = $sth->fetchAll();
            }

        }catch(PDOException $e){
            $e->getMessage();
        }

    if(isset($error)){
        return [
            'error' => $error,
        ];
    }

    return [
        'recipes'=>$recipes,
    ];
       
}