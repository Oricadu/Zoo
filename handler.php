<?php
	require_once('connection.php');

	if (isset($_GET['EXIT'])) {
		$exit = $_GET['EXIT'];
		session_start();
		session_unset();
		session_destroy();
		echo json_encode($exit);
		exit;
	}

	if(isset($_POST['auth_data'])){
		$req = false; // изначально переменная для "ответа" - false
	  	parse_str($_POST['auth_data'], $auth_data); // разбираем строку запроса
	  	// Приведём полученную информацию в удобочитаемый вид
	  	ob_start(); //Включение буферизации вывода:  никакой вывод скрипта не отправляется (кроме заголовков), а сохраняется во внутреннем буфере.

	  	$login = $auth_data['login'];
		$password = $auth_data['password'];
		$query = "select * from `users` where login = '$login' and password = '$password'";
		$result = mysqli_query($is_connected, $query);
	  	

		$arr = mysqli_fetch_array($result);
		$nom = mysqli_num_rows($result);
	  	
			if ($nom == 0) { 
				echo "такого пользователя нет в системе"; 
			}else{ 
				echo "Здравствуйте, ".$arr['name']; // вернем полученное в ответе
				session_start();
				$_SESSION['userID'] = $arr['ID'];
				$_SESSION['userLogin'] = $arr['login'];
				$_SESSION['userName'] = $arr['name'];
				$_SESSION['userStatus'] = $arr['status'];
				echo "<script>location.reload();</script>";
				//session_destroy();
				/*print_r(session_encode());
				print_r(session_decode(session_encode()));*/
				//echo session_save_path();
			}


		  	$req = ob_get_contents(); //Получает содержимое буфера без его очистки.
		  	//Функция вернет содержимое буфера вывода или FALSE, если буферизация вывода не активирована.
	  	ob_end_clean(); //Очистить (стереть) буфер вывода и отключить буферизацию вывода
	  	//Эта функция удаляет содержимое самого верхнего буфера вывода и отключает эту буферизацию.
	  	echo json_encode($req); // вернем полученное в ответе
	  	exit;
	}

	if(isset($_POST['reg_data'])){
		$req = false; // изначально переменная для "ответа" - false
	  	parse_str($_POST['reg_data'], $reg_data); // разбираем строку запроса
	  	// Приведём полученную информацию в удобочитаемый вид
	  	ob_start(); //Включение буферизации вывода:  никакой вывод скрипта не отправляется (кроме заголовков), а сохраняется во внутреннем буфере.

	  	$login = $reg_data['login'];
		$password = $reg_data['password'];
		$name = $reg_data['name'];

		$sql = "insert into `users` (`login`, `password`, `name`) values ('$login', '$password', '$name')";

		$result = mysqli_query($is_connected, $sql) or die('Query error: <code>'.$sql.'</code>');

  	
		if ($result) { 
			echo "Регистрация прошла успешно, здравствуйте ".$reg_data['name']; // вернем полученное в ответе
		}else{ 
			echo "Не удалось создать пользователя"; 
		}


		$req = ob_get_contents(); //Получает содержимое буфера без его очистки.
		  	//Функция вернет содержимое буфера вывода или FALSE, если буферизация вывода не активирована.
	  	ob_end_clean(); //Очистить (стереть) буфер вывода и отключить буферизацию вывода
	  	//Эта функция удаляет содержимое самого верхнего буфера вывода и отключает эту буферизацию.
	  	echo json_encode($req); // вернем полученное в ответе
	  	exit;
	}

?>