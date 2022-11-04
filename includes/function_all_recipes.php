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

            $sql->execute();
            $result = $sql->fetch();

            $recipes_nb = (int)$result['recipe_nb'];

            if ($recipes_nb == 0) {

                $error['empty'] = 'Oups.. Aucune recette n\'a été trouvée';

            } else {

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


?>