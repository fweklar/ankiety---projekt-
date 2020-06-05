<?php

  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Musisz się zalogować!";
  	header('location: /phpoll/registration/login.php');
  }
  $superuser = 'Administrator';
  if ($superuser == $_SESSION['username']) {
	$votereasult = 'location: result.php?';
	$votereasult .= $_SERVER['QUERY_STRING'];
	header($votereasult);
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: /phpoll/registration/login.php");
  }

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$votehash = '';
$msghash = '';
$hide = 'hidden';
if (isset($_GET['id'])) {
	

    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$user_session = $_SESSION['username'];
		$stmt = $pdo->prepare('SELECT id FROM user_answers WHERE username = :user_session and poll_id = :getid ');
		$stmt->execute([':user_session' => $user_session ,':getid' => $_GET['id']]);
		$user_answer = $stmt->fetchColumn();
		$superuser = 'Administrator';
        if (isset($_POST['poll_answer'])) {
			if ($superuser == $_SESSION['username']) {
				$msg = 'Administrator nie może głosować!';
			} else if ($user_answer != NULL) {
                $msg = 'Już oddałeś głos w tej ankiecie!';
            } else {
				
				$stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
				$stmt->execute([$_POST['poll_answer']]);
                $stmt = $pdo->prepare('INSERT INTO user_answers VALUES (NULL, ?, ?)');
				$stmt->execute([$_SESSION['username'], $_GET['id']]);
				
				$password = $_SESSION['username'];
				$password .= $_SESSION['password'];
				$password .= $_GET['id'];
				
				$stmt = $pdo->prepare('INSERT INTO hashes VALUES (NULL, ?)');
				$stmt->execute(array(md5($password)));
				$hide = 'checkyes';
				$msghash = 'Twój wygenerowany hash dla tej ankiety to:';
				$votehash = md5($password);
				
			}
        }
    } else {
        die ('Ankieta o takim ID nie istnieje.');
    }


} else {
    die ('Nie określono ID ankiety.');
}
?>

<?=template_header('Głosowanie')?>

<div class="content vote">
	<h2><?=$poll['title']?></h2>
	<p><?=$poll['desc']?></p>
    <form action="vote.php?id=<?=$_GET['id']?>" method="post">
		<?php for ($i = 0; $i < count($poll_answers); $i++): ?>
        <label>
            <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>"<?=$i == 0 ? ' checked' : ''?>>
            <?=$poll_answers[$i]['title']?>
        </label>
		<?php endfor; ?>
        <div>
		
            <input type="submit" value="Zagłosuj">
            <a href="result.php?id=<?=$poll['id']?>">Sprawdź wyniki</a>
  	</div>
    </form>
	<br>
	<?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
	
	<div class ="<?=$hide?>">
	<p><?=$msghash?></p>
	<?php if ($votehash): ?>
    <p class="hidevote"><?=$votehash?></p>
    <?php endif; ?>
	</div>

	
</div>

<?=template_footer()?>
