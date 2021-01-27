<?php 
require_once __DIR__ . '/../config.php';

$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
$name		= "" != trim($_POST["uname"]) ? 	htmlspecialchars($_POST["uname"]) : null;
$email 		= "" != trim($_POST["uemail"]) ? 	htmlspecialchars($_POST["uemail"]) : null;
$message	= "" != trim($_POST["umessage"]) ? htmlspecialchars($_POST["umessage"]) : null;

try {
	if (is_null($name) || is_null($email) || is_null($message)) {
		echo json_encode(["status" => "error", "message" => "Заполните все поля"]);
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
		echo json_encode(["status" => "error", "message" => "Введите валидный email"]);
	} else {	 
		$query = "INSERT INTO guest_messages 
					SET name 		= :name, 
						email 		= :email, 
						message 	= :message, 
						status  	= 'moderation',
						`timestamp` = NOW()";
		$stmt = $db->prepare($query);
		$stmt->execute([
			"name"		=> $name,
			"email" 	=> $email,
			"message" 	=> $message,
		]);
		echo json_encode(["status" => "success", "message" => "Ваше сообщение будет опубликованно после одобрения модератором"]);		
	}
} catch(\Exception $e) {
	echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} catch(\Error $e) {
	echo json_encode(["status" => "error", "message" => $e->getMessage()]);
};
?>