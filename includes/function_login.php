<?php
include "./data_base.php";


const STATUS_ERROR = 'error';
const STATUS_SUCCESS = 'success';


function fct_connexion(array $array)
{
	$data = $array ?? [];
	$status = STATUS_SUCCESS;
	$errors = [];


	if (empty($data['password'])) {
		$status = STATUS_ERROR;
		$errors['password'] = 'Le mot de passe est vide';
	}

	if (empty($data['email'])) {
		$status = STATUS_ERROR;
		$errors['email'] = 'L\'email est vide';
	}

	if (!empty($data['email'])) {

		if ((!filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
			$status = STATUS_ERROR;
			$errors['invalid_email'] = 'Merci de renseigner un email valide';
		}
	}

	if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !empty($data['email'])) {

		$dbco = getConnexion();

		$email = trim($data['email']);

		$sth = $dbco->prepare("SELECT COUNT(user_id) AS count FROM user
			WHERE user_email = :email");
		$sth->bindParam(':email', $email);
		$sth->execute();

		$result = $sth->fetch();

		if ($result['count'] == 0) {
			$status = STATUS_ERROR;
			$errors['invalid_count'] = 'Vos identifiants sont invalides';
		}
	}

	if ($status == STATUS_SUCCESS) {

		$pass = $data['password'];
		$email = $data['email'];

		try {
			$sth = $dbco->prepare("SELECT password FROM user
									WHERE user_email = :email");

			$sth->bindParam(':email', $email);
			$sth->execute();

			$pass_hash = $sth->fetch();

			if (strlen($pass_hash['password']) > 20) {

				if (!password_verify($pass, $pass_hash['password'])) {
					$status = STATUS_ERROR;
					$errors['invalid_hash'] = 'Vos identifiants sont invalides';
				}
			}

			if (strlen($pass_hash['password']) <= 20) {

				if ($pass !== $pass_hash['password']) {
					$status = STATUS_ERROR;
					$errors['invalid_hash'] = 'Vos identifiants sont invalides';
				}
			}

			if ($status == STATUS_SUCCESS) {

				$sql = $dbco->prepare("
				SELECT user_id FROM user
				WHERE user_email = :email");

				$sql->bindParam(':email', $email);

				$sql->execute();

				$user_id = $sql->fetch();
			}

		} catch (PDOException $e) {
			$status = STATUS_ERROR;
			$e->getMessage();
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

?>