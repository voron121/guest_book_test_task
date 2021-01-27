<?php 
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/init.php';

$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$query = "SELECT `id`,
				 `name`, 
				 `email`, 
				 `message`, 
				 `timestamp`,
				 `status`
			FROM guest_messages  
			ORDER BY id DESC 
			LIMIT 0, 10000";
$stmt = $db->query($query);
$messages = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Админка</title>
	<link rel="stylesheet" href="/css/main.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
	<div class="wrapper"> 
		<h2>Админка</h2>
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
								почта: <?=$message->email;?>
							</div>
							<div class="date">
								статус: <?=$message->status;?>
							</div>
						</div>
						<div class="msg">
							Комментарий: <br> <?=$message->message;?>
						</div>
						<div class="edite_form" id="edite_form_<?=$message->id;?>">
							<form method="post" action="main_actions.php">
								<input type="hidden" name="id" value="<?=$message->id;?>">
								<input type="hidden" name="action" value="edit">
								<textarea name="umessage" id="" cols="30" rows="10"><?=$message->message;?></textarea>
								<input type="submit" value="Сохранить">
							</form>
						</div>
						<div class="actions_items">
							<button id="<?=$message->id;?>" class="edite_message">Редактировать</button>
							<form method="post" action="main_actions.php">
								<input type="hidden" name="id" value="<?=$message->id;?>">
								<input type="hidden" name="action" value="delete">
								<input type="submit" value="Удалить">
							</form>
							<form method="post" action="main_actions.php">
								<input type="hidden" name="id" value="<?=$message->id;?>">
								<input type="hidden" name="action" value="approve">
								<input type="submit" value="Опубликовать">
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php endforeach;?>
			<?php endif;?>			
		</div>
	</div>
	<script src="/js/main.js"></script>
</body>
</html>