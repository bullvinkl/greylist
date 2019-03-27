<?php
include('server.php');
?>
<!DOCTYPE html>
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" lang="ru-RU">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Greylist</title>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">	

<script type="text/javascript">
$(document).ready(function(){
$("#myModal").modal('show');
});
</script>
<style>
.container {
    width: 640px;
    max-width: 100%;
    margin-top: 20px;
}
</style>
</head>
<body>
<div class="container">

<?php if (isset($_SESSION['message'])): ?>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">
        <?php
		echo $_SESSION['message_header'];
		unset($_SESSION['message_header']);
	?>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

			<?php
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <?php
		echo $_SESSION['message_footer'];
		unset($_SESSION['message_footer']);
	?>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть</button>
      </div>

    </div>
  </div>
</div>

<?php endif ?>

<?php $results = mysqli_query($db, "SELECT * FROM `greylisting_whitelist_domains` ORDER BY id DESC"); ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
	<a class="nav-link" href="/alias/">Alias</a>
    </li>
    <li class="nav-item">
	<a class="nav-link" href="/whitelist/">Whitelist</a>
    </li>
    <li class="nav-item">
	<a class="nav-link active" href="/greylist/">Greylist</a>
    </li>
    <li class="nav-item">
	<a class="nav-link disabled">Admin panel</a>
    </li>
</ul>

<div>&nbsp;</div>

<table class="table table-sm table-hover">
    <caption>List of Greylist</caption>
    <thead>
	<tr>
	    <th width=400px>&nbsp;</th>
	    <th scope="col">#</th>
	    <th scope="col">Domain</th>
	    <th scope="col" colspan="2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus"></i> Добавить</button></th>
	    <th width=400px>&nbsp;</th>
	</tr>
    </thead>
    <tbody>
<?php
$i=1;
while ($row = mysqli_fetch_array($results)) {
?>
	<tr>
	    <td width=200px>&nbsp;</td>
	    <td id="<?php echo $row['id']; ?>"><?php echo $i; $i++; ?></td>
	    <td><?php echo $row['domain']; ?></td>
	    <td><a href="server.php?edituser=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Редактировать</a></td>
	    <td><a href="server.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" ><i class="far fa-trash-alt"></i> Удалить</a></td>
	    <td width=200px>&nbsp;</td>
	</tr>
<?php
}
?>
    </tbody>
</table>


<form method="post" action="server.php" >

<!-- The Modal -->
<div class="modal fade" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Добавить домен в Whitelist</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

	<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
	<div class="form-group">
		<label>Domain:</label>
		<input class="form-control" type="text" name="domain" id="from" value="" required autofocus>
		<small>Введите доменное имя (то, что после знака "@")</small>
	</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
	<button type="submit" class="btn btn-success btn-sm" name="save"><i class="fa fa-plus"></i> Добавить</button>
	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть</button>
      </div>

    </div>
  </div>
</div>

</form>

</div>
</body>
</html>
