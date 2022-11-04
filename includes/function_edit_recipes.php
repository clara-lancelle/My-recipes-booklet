<?php 
include "./data_base.php";


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
            SELECT recipe.*, picture.*, components.*, bloc_steps.*
            FROM recipe
            INNER JOIN picture ON (picture.recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
            INNER JOIN components ON (components.fk_recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
            INNER JOIN bloc_steps ON (bloc_steps.fk_recipe_id = recipe.recipe_id and recipe.recipe_id = :recipe_id)
            ");

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


function br2nl($string){
    
    $pattern = array("<br />","<br>","<br/>");
     
    $nl = str_replace($pattern,"\n", $string); 
    
    return $nl;
}

function getEdit($array,$array_file, $recipe_id){

$data = $array ?? [];
$data_pic = $array_file ?? [];
$status = STATUS_SUCCESS;
$errors = [];

//champ change -> save
//champs inchangé -> ancienne data

//empty

    if(empty($data['title'])||empty($data['cat'])||empty($data['guest'])||empty($data['time'])
    ||empty($data['level'])||empty($data['price'])||empty($data['ing1'])||empty($data['step1'])){

        $status = STATUS_ERROR;
        $errors['empty'] = 'Merci de remplir tous les champs';

    } 

//valid_title	

	function search($string){
		$pattern = '/[<\>\?]/';

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

    if (!empty($data['cat'])&&(($data['cat']!=='Entrées')XOR($data['cat']!=='Plats')XOR($data['cat']!=='Desserts')
    XOR($data['cat']!=='Amuses bouches')
    XOR($data['cat']!=='Accompagnements')
    XOR($data['cat']!=='Sauces')
    XOR($data['cat']!=='Boissons')
    )) {

        $status = STATUS_ERROR;
        $errors['select_cat'] = 'Valeur non-autorisée';

    }

    if(!is_numeric($data['guest'])||(!is_numeric($data['time']))){
        $status = STATUS_ERROR;
	    $errors['num'] = 'Valeur non-autorisée';

    }

	if (!empty($data['level'])&&(($data['level']!=='faible')XOR($data['level']!=='moyen')XOR($data['level']!=='élevé'))) {

		
			$status = STATUS_ERROR;
			$errors['radio_level'] = 'Valeur non-autorisée';
		
	}

	if (!empty($data['price'])&&(($data['price']!=='faible')XOR($data['price']!=='moyen')XOR($data['price']!=='élevé'))) {

		$status = STATUS_ERROR;
		$errors['radio_price'] = 'Valeur non-autorisée';
 
	}


// valid_img

//si nouvelle img envoyée -->
    
    if(!empty($data_pic['picture']['name'])){

        $tmpName = $data_pic['picture']['tmp_name'];
        $name = $data_pic['picture']['name'];
        $size = $data_pic['picture']['size'];
        $error = $data_pic['picture']['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
        $maxSize = 2000000;

        if(!in_array($extension, $extensions)){
            $status = STATUS_ERROR;
            $errors['img']['ext'] = 'le format de votre image doit être : jpg, png, jpeg ou gif.';
        }

        if($size > $maxSize){
            $status = STATUS_ERROR;
            $errors['img']['size'] = 'la taille de votre image ne doit pas dépasser 2mo. <br/>
                                    astuce : prenez une capture d\'écran de votre image !';
        }
                
        if($size < $maxSize && in_array($extension, $extensions) && $error){
            $status = STATUS_ERROR;
            $errors['img']['else'] = 'votre image n\'a pas pu être chargée, veuillez réessayer ou changer d\'image.';

            $phpFileUploadErrors = array(
                0 => 'There is no error, the file uploaded with success',
                1 => 'la taille de votre image ne doit pas dépasser 2mo',
                2 => 'la taille de votre image ne doit pas dépasser 2mo',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            );
        }
    }
        
//si error mais nouvelle image valide -->
    elseif($status === STATUS_ERROR && !empty($data_pic['picture']['name'])&&empty($errors['img']['size'])){

        $tmpName = $data_pic['picture']['tmp_name'];
        $name = $data_pic['picture']['name'];
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $uniqueName = uniqid('', true);
        $new_file = $uniqueName.".".$extension; 
        move_uploaded_file($tmpName, 'Pictures/tmp/'.$new_file);
    }

// si error mais la dernière image envoyé n'a pas été changée -->    
    elseif($status === STATUS_ERROR && empty($data_pic['picture']['name']) && isset($data['picToEdit']) && $data['picToEdit']!=='false' && empty($errors['img']['size'])){
        $new_file = $data['picToEdit'];
    }

// si aucune nouvelle img -->

    else{
        $status = STATUS_SUCCESS;
    }


//connection BDD

	if ($status === STATUS_SUCCESS) { 


        $title = trim($data['title']);
        $cat = $data['cat'];
        $guest = $data['guest'];
        $time = $data['time'];
        $level = $data['level'];
        $price = $data['price'];
        $ing1 = $data['ing1'];
        $ing2 = $data['ing2'];
        $ing3 = $data['ing3'];
        $ing4 = $data['ing4'];
        $ing5 = $data['ing5'];
        $ing6 = $data['ing6'];
        $ing7 = $data['ing7'];
        $ing8 = $data['ing8'];
        $ing9 = $data['ing9'];
        $date = date('Y-m-d H:i:s');

        function nl_br($string){

            $br = str_replace("\n", "<br/>", $string);
            return $br;
        }
        

        $step1 = nl_br($data['step1']);
        if(!empty($data['step2'])){$step2 = nl_br(trim($data['step2']));}
        if(!empty($data['step3'])){$step3 = nl_br(trim($data['step3']));}
        if(!empty($data['step4'])){$step4 = nl_br(trim($data['step4']));}
        if(!empty($data['step5'])){$step5 = nl_br(trim($data['step5']));}
		
		try{ 
			$dbco = getConnexion();

            $sth = $dbco->prepare("
            UPDATE recipe
            SET recipe_title =:title, guest_number= :guest,setup_time= :setup, level=:level, price=:price, type=:type, date_time=:date
            WHERE recipe_id = :recipe_id");

                $sth -> bindParam(':title', $title);
                $sth -> bindParam(':guest', $guest);
                $sth -> bindParam(':setup', $time);
                $sth -> bindParam(':level', $level);
                $sth -> bindParam(':price', $price);
                $sth -> bindParam(':type', $cat);
                $sth -> bindParam(':date', $date);
                $sth -> bindParam(':recipe_id', $recipe_id);
                

                $sth->execute();

                // steps

				$sql = $dbco->prepare("
                UPDATE bloc_steps
                SET step1=:step1, step2=:step2, step3=:step3, step4=:step4, step5=:step5
                WHERE fk_recipe_id = :recipe_id
                ");
            
                    $sql -> bindParam(':step1', $step1);
                    $sql -> bindParam(':step2', $step2);
                    $sql -> bindParam(':step3', $step3);
                    $sql -> bindParam(':step4', $step4);
                    $sql -> bindParam(':step5', $step5);
                    $sql -> bindParam(':recipe_id', $recipe_id);

                    $sql->execute();

                //components

				$sql = $dbco->prepare("
                    UPDATE components
                    SET 
                    field_ingredient1=:ing1, 
                    field_ingredient2=:ing2, 
                    field_ingredient3=:ing3, 
                    field_ingredient4=:ing4, 
                    field_ingredient5=:ing5, 
                    field_ingredient6=:ing6, 
                    field_ingredient7=:ing7,
                    field_ingredient8=:ing8, 
                    field_ingredient9=:ing9
                    WHERE fk_recipe_id = :recipe_id
                    ");

				
				$sql -> bindParam(':ing1', $ing1);
				$sql -> bindParam(':ing2', $ing2);
				$sql -> bindParam(':ing3', $ing3);
				$sql -> bindParam(':ing4', $ing4);
				$sql -> bindParam(':ing5', $ing5);
				$sql -> bindParam(':ing6', $ing6);
				$sql -> bindParam(':ing7', $ing7);
				$sql -> bindParam(':ing8', $ing8);
				$sql -> bindParam(':ing9', $ing9);
                $sql -> bindParam(':recipe_id', $recipe_id);

				$sql->execute();

				


        //picture//

// si image envoyée non changée -->
        if(empty($data_pic['picture']['name'])&& !empty($data['picToEdit'])&& $data['picToEdit']!== 'false'){

            $new_file = $data['picToEdit'];
            $tmpName = '../tmp/'.$new_file;
            $sth = $dbco->prepare("
                    UPDATE picture
                    SET name= :name
                    WHERE recipe_id = :recipe_id");
                    
                    $sth -> bindParam(':name', $new_file);
                    $sth -> bindParam(':recipe_id', $recipe_id);

                    $sth->execute();
                    move_uploaded_file($tmpName, 'Pictures/'.$new_file);
                    unlink($tmpName);

        }
                   
// si une nouvelle image est envoyée -->
        if(!empty($data_pic['picture']['name'])){

            $tmpName = $data_pic['picture']['tmp_name'];
            $name = $data_pic['picture']['name'];
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
            $uniqueName = uniqid('', true);
            $new_file = $uniqueName.".".$extension;
            $sth = $dbco->prepare("
                    UPDATE picture
                    SET name= :name
                    WHERE recipe_id = :recipe_id");
                    
                    $sth -> bindParam(':name', $new_file);
                    $sth -> bindParam(':recipe_id', $recipe_id);

                    $sth->execute();
                    move_uploaded_file($tmpName, 'Pictures/'.$new_file);
        }
// si aucune nouvelle image --> ne fais rien
                    
		}catch(PDOException $e){
			$status = STATUS_ERROR;
            print $e->getMessage ();
			$errors['db'] = 'une erreur s\'est produite';
		}

    }

	if($status === STATUS_ERROR) {

        if(!isset($new_file)){
            $new_file = '';
        }
		return [
			'success' => false,
            'temporary_file' => $new_file,
			'errors' => $errors,
		];
	}
    
    return [
        'success' => true,
        'message' => 'votre recette à été modifiée avec succès !',
    ];

}
?>