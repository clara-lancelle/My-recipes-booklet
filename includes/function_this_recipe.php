<?php
include "./data_base.php";


const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';

function get_this_recipe($recipe_id)
{

    try {
        $dbco = getConnexion();


        $sql = $dbco->prepare("
            SELECT COUNT(recipe_id) AS count
            FROM recipe
            WHERE recipe_id = :recipe_id");
        $sql->bindParam(':recipe_id', $recipe_id);
        $sql->execute();
        $recipe_nb = $sql->fetch();

        $recipes_nb = (int)$recipe_nb['count'];

        if ($recipes_nb == 0) {

            $error['empty'] = 'Une erreur s\'est produite';

        } else {

            $sth = $dbco->prepare("
                SELECT recipe.*, picture.name, components.*, bloc_steps.*
                FROM recipe
                INNER JOIN picture ON (picture.recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
                INNER JOIN components ON (components.fk_recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
                INNER JOIN bloc_steps ON (bloc_steps.fk_recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
                ");
            $sth->bindParam(':recipe_id', $recipe_id);

            $sth->execute();

            $recipe = $sth->fetchAll();

        }

    } catch (PDOException $e) {
        $error['e'] = $e->getMessage();
    }

    if (isset($error)) {
        return [
            'error' => $error,
        ];

    }
    return [
        'recipe' => $recipe,
    ];
}
/*
 function get_pdf(string $recipe_name){
 try {
 $pdf = new HTML2PDF("p","A4","fr");
 $pdf->pdf->SetAuthor('DOE John');
 $pdf->pdf->SetTitle('coucou');
 $pdf->pdf->SetSubject('Une recette de cuisine');
 $pdf->pdf->SetKeywords('recette');
 $pdf->writeHTML('coucou');
 $pdf->Output($recipe_name.'.pdf',' D');
 } catch (HTML2PDF_exception $e) {
 echo 'une erreur s\'est produite';
 }
 }*/
?>