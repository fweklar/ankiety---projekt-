<?php

  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Musisz się zalogować!";
  	header('location: registration/login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: registration/login.php");
  }
$superuser = 'Administrator';
$errors = array();
include 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['create-poll'])) {
	if ($superuser != $_SESSION['username']) {
		array_push($errors, "Nie masz uprawnień do tworzenia ankiet!");
	} else if ($superuser == $_SESSION['username']) {
		header("location: create.php");
	}
}
if (isset($_GET['delpoll'])) {
		header("location: create.php");
}

if ($superuser != $_SESSION['username']) {
    $deletehide = "hidden";
} else {
    $deletehide = "trash";
}

if ($superuser != $_SESSION['username']) {
    $createhide = "hidden";
} else {
    $createhide = "create-poll";
}

if (isset($_POST['check-poll'])) {
		header("location: check.php");
}


?>
<?=template_header('Ankiety')?>
<div class="login content">
	<p></p>
	<?php include('registration/errors.php'); ?>
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Cześć <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">wyloguj się</a> </p>
    <?php endif ?>
</div>


<div class="content index">

	<h2>Ankiety</h2>
	<p>Witaj na naszej stronie umożliwiającej anonimowe głosowania. Tworzenie ankiet jak i głosowanie w nich jest szyfrowane. Użytkownik w każdej ankiecie może zagłosować tylko raz. Tworzyć i usuwać ankiety może tylko administrator.</p>
	<form method="POST">
	<input type="submit" name="create-poll"  class="<?=$createhide?>" value="Stwórz ankietę"><input type="submit" name="check-poll"  class="create-poll" value="Sprawdź ankietę">
	</form> 
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Tytuł</td>
				<td>Odpowiedzi</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
			<?php foreach ($polls as $poll): ?>
            <tr>
                <td><?=$poll['id']?></td>
                <td><?=$poll['title']?></td>
				<td><?=$poll['answers']?></td>
                <td class="actions">
					<form><a href="vote.php?id=<?=$poll['id']?>" class="view" title="Zobacz ankietę"><i class="fas fa-eye fa-xs"></i></a>
					<a href="delete.php?id=<?=$poll['id']?>" class="<?=$deletehide?>" id="delpoll" title="Usuń ankietę"><i class="fas fa-trash fa-xs"></i></a></form> 
                </td>
            </tr>
			<?php endforeach; ?>
        </tbody>
    </table>
</div>



<?=template_footer()?>
