<?php 
require_once __DIR__ . '/../config.php';
// supersecreetpasword;

$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$login  = "" != trim($_POST["ulogin"]) ? htmlspecialchars($_POST["ulogin"]) : null;
$upass  = "" != trim($_POST["upass"]) ? trim($_POST["upass"]) : null;

if (!is_null($login)) {
	$query = "SELECT `id`,
					 `login`, 
					 `password`
				FROM users 
				WHERE login = :login";
	$stmt = $db->prepare($query);
	$stmt->execute(["login" => $login]);
	$user = $stmt->fetch();

	if (is_null($user)) {
		die("Пользователь не найден!");
	} else { 
		if ((SALT.md5($upass).SALT) != $user->password) {
			die("Пароль не верный!");
		}
		session_start();
	    $_SESSION['uid'] = $user->id;
	    header('location: /admin/main.php');
	    exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Тестовое задание - админка</title>
	<link rel="stylesheet" href="/css/main.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="form">
			<h2>Авторизация</h2>
			<hr>
			<form method="post">
				<input type="text" name="ulogin" placeholder="Имя:">
				<input type="password" name="upass" placeholder="Почта:">
				<div class="action_adds">
					<input type="submit" value="Войти">
				</div>
			</form>
		</div>
		<hr> 
</body>
</html>