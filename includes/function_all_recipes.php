<?php 
include "data_base.php";

function get_all_recipes($current_page){
    
    try {
        $dbco = getConnexion();
        
        $sql = $dbco->prepare("
            SELECT COUNT(*) AS recipe_nb 
            FROM recipe");
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
            ORDER BY recipe.recipe_title ASC
            LIMIT :first, :parpage
            "); 
            $sth -> bindParam(':first',$first,PDO::PARAM_INT);
            $sth -> bindParam(':parpage',$parPage,PDO::PARAM_INT);
            $sth->execute();

            $recipes= $sth->fetchAll();
           

    }catch(PDOException $e){
        $e->getMessage();
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



?>