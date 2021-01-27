<?php 
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/init.php';

$message_id = (int)$_POST["id"];
$action 	= $_POST["action"];

if (is_null($message_id) || is_null($action) || !in_array($action, ["delete", "edit", "approve"])) {
	die("not valid param!");
}

$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$query = "SELECT `id`, 
				 `name`, 
				 `email`, 
				 `message`, 
				 `timestamp` 
			FROM guest_messages 
			WHERE id = :id ";
$stmt = $db->prepare($query);
$stmt->execute(["id" => $message_id]);
$message = $stmt->fetchAll();


try {
	if ("delete" === $action) {
		$query = "DELETE FROM guest_messages WHERE id = :id";
		$stmt = $db->prepare($query);
		$stmt->execute(["id" => $message_id]);
		header("Location:/admin/main.php");
	} elseif ("edit" === $action) {
		$message  = htmlspecialchars($_POST["umessage"]); 
		$query = "UPDATE guest_messages 
					SET message = :message
				WHERE id = :id";
		$stmt = $db->prepare($query);
		$stmt->execute([
			"message" => $message,
			"id" => $message_id
		]);
		header("Location:/admin/main.php");
	} else {
		$query = "UPDATE guest_messages SET status = 'approved' WHERE id = :id";
		$stmt = $db->prepare($query);
		$stmt->execute(["id" => $message_id]);
		header("Location:/admin/main.php");
	}
} catch(\Exception $e) {
	echo $e->getMessage();
}
?>
