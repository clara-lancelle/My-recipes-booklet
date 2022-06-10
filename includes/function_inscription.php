<?php

include "data_base.php";

const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';

function fct_inscription(array $array) {
	$data = $array ?? [];
	$status = STATUS_SUCCESS;
	$errors = [];

//empty

	if(empty($data['email'])||empty($data['password'])||empty($data['firstname'])||empty($data['lastname'])||empty($data['confirm_password'])) {
		$status = STATUS_ERROR;
		$errors['empty'] = 'Merci de remplir tous les champs';
	
	}

//valid_mail

	if(!empty($data['email'])&& !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
		$status = STATUS_ERROR;
		$errors['email'] = 'Merci de renseigner un email valide';
	}

//valid lastname + firstname

	function search($string){
		$pattern = '/[^a-zA-ZÀ-ÖØ-öÿŸ\-\d\s]/';

		$a = preg_match($pattern,$string)?true:false;

		return $a;
	}
	 
	if(!empty($data['firstname'])){
		
		$find_first= search($data['firstname']);

		if($find_first==true){
			$status = STATUS_ERROR;
			$errors['first'] = 'Votre prénom contient des caractères non-autorisés';
		}
	}

	if(!empty($data['lastname'])){
		$find_last= search($data['lastname']);

		if($find_last==true){
			$status = STATUS_ERROR;
			$errors['last'] = 'Votre nom contient des caractères non-autorisés';
		}
	}
//valid_password

	if(!empty($data['password'])&&!empty($data['confirm_password'])){
		if(($data['password'])!==($data['confirm_password'])){
			$status = STATUS_ERROR;
			$errors['confirm'] = 'Les mots de passe doivent être identiques';
		}
	}

//valid_email
if(!empty($data['email'])){
	$dbco = getConnexion();

		$email = trim($data['email']);

		$sth= $dbco->prepare("
		SELECT COUNT(user_id) AS count 
		FROM user 
		WHERE user_email = :email");

		$sth -> bindParam(':email', $email);
		$sth->execute();

		$result = $sth->fetch();

		if($result['count'] >= 1){
			$status = STATUS_ERROR;
			$errors['same'] = 'Cet email est déja utilisé';
		}
	}

//connection BDD

	if ($status === STATUS_SUCCESS) { 
		
		try{ 
			$dbco = getConnexion();

			$email = $data['email'];
			$first = $data['firstname'];
			$pass = $data['password'];
			$last = $data['lastname'];

			// encrypt_pass

			$pass_hash = password_hash($pass, PASSWORD_DEFAULT); 

				$add = $dbco->prepare("
				INSERT INTO user(user_email, first_name, last_name, password)
				VALUES(:email, :first, :last, :pass)");

				$add -> bindParam(':email', $email);
				$add -> bindParam(':first', $first);
				$add -> bindParam(':last', $last);
				$add -> bindParam(':pass', $pass_hash);

				$add->execute();
				$user = $add->fetch();

				$sql = $dbco->prepare("
				SELECT user_id FROM user
				WHERE user_email = :email");

				$sql -> bindParam(':email', $email);

				$sql->execute();

				$user_id = $sql->fetch();
				

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
        'id' => $user_id,
    ];

}
