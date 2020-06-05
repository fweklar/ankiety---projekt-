<?php
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Musisz się zalogować!";
  	header('location: /phpoll/registration/login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: /phpoll/registration/login.php");
  }
$superuser = 'Administrator';
if ($_SESSION['username'] != $superuser) {
  	header('location: /phpoll/index.php');
}

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
	if ($superuser != $_SESSION['username']) {
		$msg = 'Nie masz uprawnień aby stworzyć ankietę!';
	} else if ($superuser == $_SESSION['username']) {
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?)');
		$stmt->execute([$title, $desc]);	
		$poll_id = $pdo->lastInsertId();	
		$answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
		foreach ($answers as $answer) {		
			if (empty($answer)) continue;		
			$stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)');
			$stmt->execute([$poll_id, $answer]);
		}	
		$msg = 'Stworzono pomyślnie!';
	}
}
?>

<?=template_header('Tworzenie ankiety')?>

<div class="content create">
	<h2>Stwórz ankietę</h2>
    <form action="create.php" method="post">
        <label for="title">Tytuł</label>
        <input type="text" name="title" id="title">
        <label for="desc">Opis</label>
        <input type="text" name="desc" id="desc">
        <label for="answers">Odpowiedzi (jedna na linię)</label>
        <textarea name="answers" id="answers"></textarea>
        <input type="submit" value="Stwórz">
    </form>
	<?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
