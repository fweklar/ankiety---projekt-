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

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$userhash = '';
$msghash = '';

if (!empty($_POST['userhash'])) {
	$userhash = $_POST['userhash'];
	$sql = "SELECT COUNT(*) AS num FROM `hashes` WHERE userhash = :userhash";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':userhash', $userhash);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
 
	if($row['num'] > 0){
		$yesorno = 'checkyes';
		$msghash = 'Kod ankiety znajduje się w bazie!';		
	} else {
		$yesorno = 'checkno';
		$msghash = 'Nie ma takiego kodu w bazie!';
	}
}
?>

<?=template_header('Sprawdzenie ankiety')?>

<div class="content create">
	<h2>Sprawdź ankietę</h2>
    <form action="check.php" method="post">
        <label>Wpisz swój wygenerowany kod hash:</label>
        <input type="text" name="userhash">
        <input type="submit" value="Sprawdź">
    </form>
	
	<?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
	
	<div class ="<?=$yesorno?>">
	<?php if ($msghash): ?>
	<p class ="userhash"><?=$userhash?></p>
    <p><?=$msghash?></p>
    <?php endif; ?>
	</div>

</div>

<?=template_footer()?>