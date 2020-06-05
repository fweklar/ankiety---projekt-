<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <title>Ankiety</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Rejestracja</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Nazwa użytkownika</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Hasło</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Powtórz hasło</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Zarejestruj się</button>
  	</div>
  	<p>
  		Jesteś już użytkownikiem? <a href="login.php">Zaloguj się</a>
  	</p>
  </form>
</body>
</html>