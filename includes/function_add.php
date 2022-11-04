<?php
include "./data_base.php";

const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';

function ttt_form(array $array, array $file)
{
	$data = $array ?? [];
	$data_pic = $file ?? [];
	$status = STATUS_SUCCESS;
	$errors = [];

	//empty
	if (empty($data['title'])) {
		$status = STATUS_ERROR;
		$errors['title'] = ' Le titre n\'est pas renseigné ';
	}

	if (empty($data['cat'])) {
		$status = STATUS_ERROR;
		$errors['cat'] = 'La catégorie n\'est pas renseigné';
	}

	if (empty($data['guest'])) {
		$status = STATUS_ERROR;
		$errors['guest'] = ' La quantité n\'est pas renseignée ';
	}


	if (empty($data['time'])) {
		$status = STATUS_ERROR;
		$errors['time'] = ' Le temps de préparation n\'est pas renseigné ';
	}


	if (empty($data['level'])) {
		$status = STATUS_ERROR;
		$errors['level'] = ' Le niveau de difficulté n\'est pas renseigné ';
	}

	if (empty($data['price'])) {
		$status = STATUS_ERROR;
		$errors['price'] = 'Le coût n\'est pas renseigné';
	}

	if (empty($data['ing1'])) {
		$status = STATUS_ERROR;
		$errors['ing'] = 'Vous devez renseigner au moins un ingrédient';
	}

	if (empty($data['step1'])) {
		$status = STATUS_ERROR;
		$errors['step'] = 'Vous devez renseigner au moins une étape';
	}

	//valid_picture

	if (empty($data_pic['picture']['name']) && empty($data['picToEdit'])) {
		$status = STATUS_ERROR;
		$errors['picture'] = 'Vous devez illustrer votre recette';
	}

	//si nouvelle img envoyée -->

	if (!empty($data_pic['picture']['name'])) {

		$tmpName = $data_pic['picture']['tmp_name'];
		$name = $data_pic['picture']['name'];
		$size = $data_pic['picture']['size'];
		$error = $data_pic['picture']['error'];

		$tabExtension = explode('.', $name);
		$extension = strtolower(end($tabExtension));
		$extensions = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
		$maxSize = 2000000;

		if (!in_array($extension, $extensions)) {
			$status = STATUS_ERROR;
			$errors['img']['ext'] = 'le format de votre image doit être : jpg, png, jpeg ou gif.';
		}

		if ($size > $maxSize) {
			$status = STATUS_ERROR;
			$errors['img']['size'] = 'la taille de votre image ne doit pas dépasser 2mo. <br/>
                                    astuce : prenez une capture d\'écran de votre image !';
		}

		if ($size < $maxSize && in_array($extension, $extensions) && $error) {
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
	if ($status === STATUS_ERROR && !empty($data_pic['picture']['name']) && empty($errors['img']['size'])) {

		$tmpName = $data_pic['picture']['tmp_name'];
		$name = $data_pic['picture']['name'];
		$tabExtension = explode('.', $name);
		$extension = strtolower(end($tabExtension));
		$uniqueName = uniqid('', true);

		$new_file = $uniqueName . "." . $extension;
		move_uploaded_file($tmpName, 'Pictures/tmp/' . $new_file);
	}

	// si error mais la dernière image envoyé n'a pas été changée -->    
	if ($status === STATUS_ERROR && empty($data_pic['picture']['name']) && isset($data['picToEdit']) && !empty($data['picToEdit'] && empty($errors['img']['size']))) {
		$new_file = $data['picToEdit'];
	}

	//valid_title	

	function search($string)
	{
		$pattern = '/[<\>\?]/';

		$a = preg_match($pattern, $string) ? true : false;

		return $a;
	}

	if (!empty($data['title'])) {
		$find = search($data['title']);

		if ($find == true) {
			$status = STATUS_ERROR;
			$errors['sort'] = 'Votre titre contient des caractères non-autorisés';
		}
	}

	//valid_value

	if (!empty($data['cat']) && (($data['cat'] !== 'Entrées') xor ($data['cat'] !== 'Plats') xor ($data['cat'] !== 'Desserts') xor ($data['cat'] !== 'Amuses bouches') xor ($data['cat'] !== 'Accompagnements') xor ($data['cat'] !== 'Sauces') xor ($data['cat'] !== 'Boissons'))) {


		$status = STATUS_ERROR;
		$errors['select_cat'] = 'Valeur non-autorisée';

	}

	if (!is_numeric($data['guest']) || (!is_numeric($data['time']))) {
		$status = STATUS_ERROR;
		$errors['num'] = 'Valeur non-autorisée';

	}

	if (!empty($data['level']) && (($data['level'] !== 'faible') xor ($data['level'] !== 'moyen') xor ($data['level'] !== 'élevé'))) {


		$status = STATUS_ERROR;
		$errors['radio_level'] = 'Valeur non-autorisée';

	}

	if (!empty($data['price']) && (($data['price'] !== 'faible') xor ($data['price'] !== 'moyen') xor ($data['price'] !== 'élevé'))) {

		$status = STATUS_ERROR;
		$errors['radio_price'] = 'Valeur non-autorisée';

	}


	if ($status === STATUS_ERROR) {

		if (!isset($new_file)) {
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
	];

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VALIDATION

function getRecipe($array, $array_file, $id)
{

	$data = $array ?? [];
	$data_pic = $array_file ?? [];
	$status = STATUS_SUCCESS;
	$errors = [];
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

	function nl_br($string)
	{

		$br = str_replace("\n", "<br/>", $string);
		return $br;
	}

	$step1 = nl_br(trim($data['step1']));
	if (!empty($data['step2'])) {
		$step2 = nl_br(trim($data['step2']));
	}
	if (!empty($data['step3'])) {
		$step3 = nl_br(trim($data['step3']));
	}
	if (!empty($data['step4'])) {
		$step4 = nl_br(trim($data['step4']));
	}
	if (!empty($data['step5'])) {
		$step5 = nl_br(trim($data['step5']));
	}

	$int_id = intval($id);


	try {
		$dbco = getConnexion();

		$sql = $dbco->prepare("
				SELECT COUNT(recipe_id) AS count
				FROM recipe 
				WHERE recipe_title = :title && author_id = :author_id");

		$sql->bindParam(':title', $title);
		$sql->bindParam(':author_id', $int_id);

		$sql->execute();

		$recipe_count = $sql->fetch();

		if ($recipe_count['count'] >= 1) {
			$status = STATUS_ERROR;
			$errors['count'] = 'Vous avez déja enregistré cette recette';
		}

		if ($status == STATUS_SUCCESS) {

			//recipe//
			$dbco->beginTransaction();

			$sth = $dbco->prepare("
					INSERT INTO recipe(recipe_title,guest_number,setup_time,level,price,author_id,type,date_time)
					VALUES (:title, :guest, :setup, :level, :price, :author_id, :type, :date)");

			$sth->bindParam(':title', $title);
			$sth->bindParam(':guest', $guest);
			$sth->bindParam(':setup', $time);
			$sth->bindParam(':level', $level);
			$sth->bindParam(':price', $price);
			$sth->bindParam(':author_id', $int_id);
			$sth->bindParam(':type', $cat);
			$sth->bindParam(':date', $date);

			$sth->execute();

			// recipe_id

			$sql = $dbco->prepare("
					SELECT recipe_id FROM recipe 
					WHERE recipe_title = :title && author_id = :author_id");

			$sql->bindParam(':title', $title);
			$sql->bindParam(':author_id', $int_id);

			$sql->execute();

			$recipe_id = $sql->fetch();

			//components

			$sql = $dbco->prepare("
					INSERT INTO components(fk_recipe_id, field_ingredient1,
						field_ingredient2, field_ingredient3, field_ingredient4,
						field_ingredient5, field_ingredient6, field_ingredient7, field_ingredient8, field_ingredient9)
					VALUES (:id, :ing1, :ing2, :ing3, :ing4, :ing5, :ing6, :ing7, :ing8, :ing9) 
				");

			$sql->bindParam(':id', $recipe_id['recipe_id']);
			$sql->bindParam(':ing1', $ing1);
			$sql->bindParam(':ing2', $ing2);
			$sql->bindParam(':ing3', $ing3);
			$sql->bindParam(':ing4', $ing4);
			$sql->bindParam(':ing5', $ing5);
			$sql->bindParam(':ing6', $ing6);
			$sql->bindParam(':ing7', $ing7);
			$sql->bindParam(':ing8', $ing8);
			$sql->bindParam(':ing9', $ing9);

			$sql->execute();


			// steps

			$sql = $dbco->prepare("
					INSERT INTO bloc_steps(step1, step2, step3, step4, step5, fk_recipe_id)
					VALUES (:step1, :step2, :step3, :step4, :step5, :id)
				");

			$sql->bindParam(':step1', $step1);
			$sql->bindParam(':step2', $step2);
			$sql->bindParam(':step3', $step3);
			$sql->bindParam(':step4', $step4);
			$sql->bindParam(':step5', $step5);
			$sql->bindParam(':id', $recipe_id['recipe_id']);

			$sql->execute();


			//picture//

			// si image envoyée non changée -->
			if (empty($data_pic['picture']['name']) && !empty($data['picToEdit'])) {

				$new_file = $data['picToEdit'];
				$tmpName = '../tmp/'. $new_file;
				$sth = $dbco->prepare("
					UPDATE picture
					SET name= :name
					WHERE recipe_id = :recipe_id");

				$sth->bindParam(':name', $new_file);
				$sth->bindParam(':recipe_id', $recipe_id['recipe_id']);

				$sth->execute();
				move_uploaded_file($tmpName, 'Pictures/' . $new_file);
				unlink($tmpName);


			}
			// si une nouvelle image est envoyée -->
			if (!empty($data_pic['picture']['name'])) {

				$tmpName = $data_pic['picture']['tmp_name'];
				$name = $data_pic['picture']['name'];
				$tabExtension = explode('.', $name);
				$extension = strtolower(end($tabExtension));
				$uniqueName = uniqid('', true);
				$new_file = $uniqueName . "." . $extension;
				$sth = $dbco->prepare("
					UPDATE picture
					SET name= :name
					WHERE recipe_id = :recipe_id");

				$sth->bindParam(':name', $new_file);
				$sth->bindParam(':recipe_id', $recipe_id['recipe_id']);

				$sth->execute();
				move_uploaded_file($tmpName, 'Pictures/' . $new_file);
			}

			$dbco->commit();

		}

	} catch (PDOException $e) {
		$status = STATUS_ERROR;
		$dbco->rollBack();
		print $e->getMessage();
		$errors['else'] = 'une erreur s\'est produite';
	}


	if ($status === STATUS_ERROR) {

		if (!isset($new_file)) {
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
		'message' => 'Votre recette à été enregistrée avec succès !',
	];


}


?>