<?php 
	session_start();
	$db = mysqli_connect('localhost', 'iredapd', '', 'iredapd');
        // Check connection
        if (!$db)
           {
           die("Connection error: " . mysqli_connect_error());
           }

/* добавить пользователя */
if (isset($_POST['save'])) {
	$domain = $_POST['domain'];
	/*проверка, еслть ли такой пользователь*/
	$results = mysqli_query($db, "SELECT id FROM `greylisting_whitelist_domains` WHERE domain='$domain'");
	$row = mysqli_fetch_array($results);
	if (!empty($row['id'])) {
		$_SESSION['message_header'] = "Ошибка при добавлении";
		$_SESSION['message'] = "Доменное имя <strong>$domain</strong> уже есть в базе.";
		$_SESSION['message_footer'] = "";
	}
else {
		mysqli_query($db, "INSERT INTO `greylisting_whitelist_domains` (domain) VALUES ('$domain')");
		$_SESSION['message_header'] = "Домен добавлен";
		$_SESSION['message'] = "Домен: @<strong>$domain</strong>";
		$_SESSION['message_footer'] = "";
	}
		header('location: index.php');
}

/* вывод формы редактирования пользователя */
if (isset($_GET['edituser'])) {
	$id = $_GET['edituser'];
	$results = mysqli_query($db, "SELECT * FROM `greylisting_whitelist_domains` WHERE id=$id");
	$row = mysqli_fetch_array($results);
	$domain = $row['domain'];
	$_SESSION['message_header'] = "Редактировать домен <strong>$domain</strong>";
	$_SESSION['message'] = "<form method=\"post\" action=\"server.php\">
	<input type=\"hidden\" name=\"id\" value=\"$id\">
	<div class=\"form-group\">
	<label>Домен:</label>
	<input class=\"form-control\" type=\"text\" name=\"domain\" value=\"$domain\" maxlength=\"99\" autofocus>
	</div>";
	$_SESSION['message_footer'] = "<button class=\"btn btn-success btn-sm\" type=\"submit\" name=\"update\"><i class=\"fas fa-sync\"></i> Обновить</button>
	</form>";
	header('location: index.php#'.$id.'');
}

/* Обновление */
if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$domain = $_POST['domain'];
	mysqli_query($db, "UPDATE `greylisting_whitelist_domains` SET domain='$domain' WHERE id=$id");
	$_SESSION['message_header'] = "Домен обновлен";
	$_SESSION['message'] = "Домен: <strong>$domain</strong><br>";
	$_SESSION['message_footer'] = "";
	header('location: index.php#'.$id.'');
}


/* удаление */
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$results = mysqli_query($db, "SELECT * FROM `greylisting_whitelist_domains` WHERE id=$id");
	$row = mysqli_fetch_array($results);
	$domain = $row['domain'];
	mysqli_query($db, "DELETE FROM `greylisting_whitelist_domains` WHERE id=$id");
	$_SESSION['message_header'] = "Домен удален";
	$_SESSION['message'] = "Домен: <strong>$domain</strong>";
	$_SESSION['message_footer'] = "";
	header('location: index.php');
}
?>
