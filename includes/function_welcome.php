<<<<<<< HEAD
<?php
include "./data_base.php";

function get_recent_recipes()
{

    try {
        $dbco = getConnexion();

        $sql = $dbco->prepare("
=======
<?php 
include "data_base.php";

function get_recent_recipes(){

try {
            $dbco = getConnexion();
        
            $sql = $dbco->prepare("
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
                SELECT COUNT(*) AS recipe_nb 
                FROM recipe
                ");

<<<<<<< HEAD
        $sql->execute();
        $result = $sql->fetch();

        $recipes_nb = (int)$result['recipe_nb'];

        if ($recipes_nb == 0) {

            $error['empty'] = 'Oups.. Aucune recette n\'a été trouvée';

        } else {
=======
                $sql->execute();
                $result= $sql->fetch();
                
            $recipes_nb = (int) $result['recipe_nb'];

            if($recipes_nb == 0) {
                
                $error['empty'] = 'Oups.. Aucune recette n\'a été trouvée';

            } else {
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355


            $sth = $dbco->prepare("
                SELECT picture.*, recipe.*, user.*
                FROM picture 
                INNER JOIN recipe ON recipe.recipe_id = picture.recipe_id
                INNER JOIN user ON user.user_id = recipe.author_id
                ORDER BY recipe.date_time DESC
                LIMIT 3
<<<<<<< HEAD
                ");
            $sth->execute();

            $recipes = $sth->fetchAll();
        }

    } catch (PDOException $e) {
        $e->getMessage();
    }

    if (isset($error)) {
=======
                "); 
                $sth->execute();

                $recipes = $sth->fetchAll();
            }

        }catch(PDOException $e){
            $e->getMessage();
        }

    if(isset($error)){
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
        return [
            'error' => $error,
        ];
    }

    return [
<<<<<<< HEAD
        'recipes' => $recipes,
    ];

=======
        'recipes'=>$recipes,
    ];
       
>>>>>>> 2b5d20c52d37e0d3f44100c1119faf8f34087355
}