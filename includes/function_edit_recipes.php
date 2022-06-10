<?php 
include "data_base.php";


const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';



function getData($id){
    try {
        $dbco = getConnexion();

        $sql = $dbco->prepare("
            SELECT COUNT(recipe_id) AS count
            FROM recipe
            WHERE recipe_id = :recipe_id"); 
        $sql -> bindParam(':recipe_id', $id);
        $sql->execute();
        $recipe_nb = $sql->fetch();

        if($recipe_nb['count'] == 0) {
            
            $error['empty'] = 'Recette introuvable';

        } else {
            $sth = $dbco->prepare("
                SELECT picture.name, recipe.*
                FROM picture 
                INNER JOIN recipe 
                ON picture.recipe_id = recipe.recipe_id 
                && recipe.recipe_id = :recipe_id");

            $sth -> bindParam(':recipe_id', $id);
            $sth->execute();

            $recipe = $sth->fetchAll();
            
        }
        
    }catch(PDOException $e){
        $error['e'] = $e->getMessage();
    }

    if(isset($error)){
        return [
            'error' => $error,
        ];
        
    }
    return $recipe;
} 



function getEdit($array,$array_file, $recipe_id){

$data = $array ?? [];
$data_pic = $array_file ?? [];
$status = STATUS_SUCCESS;
$errors = [];

//champ change -> save
//champs inchangé -> ancienne data

//empty

    if(empty($data['title'])||empty($data['guest'])||empty($data['time'])
    ||empty($data['level'])||empty($data['price'])||empty($data_pic['picture']['name'])){

        $status = STATUS_ERROR;
        $errors['empty'] = 'Merci de remplir tous les champs';

    } 

//valid_title	

	function search($string){
		$pattern = '/[^a-zA-ZÀ-ÖØ-öÿŸ\-\d\s]/';

		$a = preg_match($pattern,$string)?true:false;

		return $a;
	}

	if(!empty($data['title'])){
		$find= search($data['title']);

		if($find==true){
			$status = STATUS_ERROR;
			$errors['sort'] = 'Votre titre contient des caractères non-autorisés';
		}
	}


//valid_value

	if (!empty($data['level'])&&(($data['level']!=='faible')XOR($data['level']!=='moyen')XOR($data['level']!=='élevé'))) {

		
			$status = STATUS_ERROR;
			$errors['radio_level'] = 'Valeur non-autorisée';
		
	}

	if (!empty($data['price'])&&(($data['price']!=='faible')XOR($data['price']!=='moyen')XOR($data['price']!=='élevé'))) {

		$status = STATUS_ERROR;
		$errors['radio_price'] = 'Valeur non-autorisée';
 
	}

//connection BDD

	if ($status === STATUS_SUCCESS) { 


        $title = trim($data['title']);
        $guest = $data['guest'];
        $time = $data['time'];
        $level = $data['level'];
        $price = $data['price'];
		
		try{ 
			$dbco = getConnexion();

            $sth = $dbco->prepare("
            UPDATE recipe
            SET recipe_title =:title, guest_number= :guest,setup_time= :setup, level=:level, price=:price
            WHERE recipe_id = :recipe_id");

                $sth -> bindParam(':title', $title);
                $sth -> bindParam(':guest', $guest);
                $sth -> bindParam(':setup', $time);
                $sth -> bindParam(':level', $level);
                $sth -> bindParam(':price', $price);
                $sth -> bindParam(':recipe_id', $recipe_id);

                $sth->execute();

        //picture//


                $tmpName = $data_pic['picture']['tmp_name'];
                $name = $data_pic['picture']['name'];
                $size = $data_pic['picture']['size'];
                $error = $data_pic['picture']['error'];


				$tabExtension = explode('.', $name);
				$extension = strtolower(end($tabExtension));
				$extensions = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
				$maxSize = 400000;

					if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
						
						$status = STATUS_SUCCESS;
						$uniqueName = uniqid('', true);
						$file = $uniqueName.".".$extension;

						$sth = $dbco->prepare("
							UPDATE picture
                            SET name= :name
							WHERE recipe_id = :recipe_id");
							
							$sth -> bindParam(':name', $file);
                            $sth -> bindParam(':recipe_id', $recipe_id);

							$sth->execute();
							move_uploaded_file($tmpName, '../Pictures/'.$file);

						} else {
							$status = STATUS_ERROR;
							$errors['invalid']=' Votre fichier n\'est pas valide,'.'</br></br>'. 'il doit être au format : jpg, png, jpeg ou gif.';
						}
			

		}catch(PDOException $e){
			$status = STATUS_ERROR;
			$errors['db'] = 'une erreur s\'est produite';
		}

	}

	if ($status === STATUS_ERROR) {
		return [
			'success' => false,
			'errors' => $errors,
		];
	}
    
    return [
        'success' => true,
        'message' => 'votre recette à été modifiée avec succès !',
    ];

}
?>