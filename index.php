<?php 
require_once __DIR__ . '/config.php';

$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$query = "SELECT `name`, 
				 `email`, 
				 `message`, 
				 `timestamp` 
			FROM guest_messages 
			WHERE status = 'approved' 
			ORDER BY id DESC 
			LIMIT 0, 10000";
$stmt = $db->query($query);
$messages = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Тестовое задание</title>
	<link rel="stylesheet" href="/css/main.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="form">
			<h2>Гостевая книга</h2>
			<hr>
			<input type="text" name="uname" placeholder="Имя:">
			<input type="text" name="uemail" placeholder="Почта:">
			<textarea name="umessage" id="" cols="30" rows="10"></textarea>
			<div class="action_adds">
				<button onclick=writePost();>Отправить</button>	
			</div>
		</div>
		<hr>
		<div class="info_message"></div>
		<div class="messages">
			<?php if (count($messages) === 0) :?>
				<b>Пока что нет ни одного отзыва. Будьте первым, оставьте свой отзыв!</b>
			<?php else:?>
				<?php foreach($messages as $message):?>
					<div class="message">
						<div class="m_header">
							<div class="name">
								Пользователь: <?=$message->name;?>
							</div>
							<div class="date">
								дата: <?=$message->timestamp;?>
							</div>
						</div>
						<div class="msg">
							<?=$message->message;?>
						</div>
					</div>
				<?php endforeach;?>
			<?php endif;?>			
		</div>
	</div>
	<script src="/js/main.js"></script>
</body>
</html>