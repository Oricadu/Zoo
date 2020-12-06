<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>zoo</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<meta name="viewport" content="width=device-width">

</head>
<body>
	<header>

		<nav>
			
			<ul>
				<li>
					<a href="" class="nav active" data-id="1">Животные</a>
				</li>
				<li>
					<a href="" class="nav" data-id="2">Питание</a>
				</li>
				<li>
					<a href="" class="nav" data-id="3">Игрушки</a>
				</li>
				<li>
					<button class="enter">
						<?php
							session_start();
							if (isset($_SESSION['userID'])) {
								echo $_SESSION['userLogin'];
								echo "<br>Выйти";
								?>
								<script type="text/javascript">
									$('.enter').toggleClass('exit').toggleClass('enter');

								</script>
								<?php
							}else{
								echo "Войти";
							} 

						?>
					</button>
				</li>
				

			</ul>
		</nav>
		
		<div class="modal_background">
			<div class="modal_form">
				<button type="button" class="close_form" >X</button>
				<div id="auth">
					
					<form action="handler.php" method="POST" id="auth_form">
						<p>Введите логин</p>
						<input type="text" name="login">
						<p>Введите пароль</p>
						<input type="password" name="password">
						<input type="submit" name="enter" value="Войти" class='button'>
					</form>

				</div>
					<div id="reg">
						<p>Еще не зарегистрированы?</p>
						<button class="reg" class='button'>Создать аккаунт</button>
					</div>

				<div id="register">
					<form action="handler.php" method="POST" id="reg_form">
						<p>Введите логин</p>
						<input type="text" name="login">
						<p>Введите пароль</p>
						<input type="password" name="password">
						<p>Повторите пароль</p>
						<input type="password" name="repPass">
						<p>Введите имя</p>
						<input type="text" name="name">
						<input type="submit" name="register" value="Зарегистрироваться" class='button'>
					</form>
				</div>

			</div>
		</div>
	</header>
	<main>
		
		<div class="catalog" data-catalog="pets">
			<!-- <div class="addForm"> -->
				<?php
					/*require_once('connection.php');

					$query = "select * from `pets`";

					$result = mysqli_query($is_connected, $query);

					*/
				?>
			<!-- </div> -->
		</div>
	</main>
	<footer>
		
	</footer>
</body>
</html>
