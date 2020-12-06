<?php
	require_once('connection.php');
	session_start();



		if (isset($_GET['BUY'])) {
			//echo "string";
			$id = $_GET['ID'];
			$section = $_GET['SECTION'];
			//echo $_GET['BUY']." $id $section";

			if ($section == 'pets'){
				$query = "delete from `$section` WHERE `ID` = $id";
				ob_start();
				
					//echo "$id";

					//echo ($query);
				
					$result = mysqli_query($is_connected, $query);
					if ($result) {
						echo "Вы купили питомца";
					}
				
					$req = ob_get_contents();

				ob_end_clean();
				echo json_encode($req);

			} else if (($section == 'nutrition') or ($section == 'toys')){
				$sql = "select `amount` from `$section` where ID=$id";
				ob_start();
					//echo "$sql";
					$result = mysqli_query($is_connected, $sql);

					$row = mysqli_fetch_array($result);
					$amount = $row['amount'];
				
				
					//echo "$amount";

					$amount--;


					$query = "update `$section` set `amount`=$amount where ID = $id";
					//echo "$query";
					$result = mysqli_query($is_connected, $query);
					if ($result) {
						echo "Вы купили товар";
					}
					
					$req = ob_get_contents();

				ob_end_clean();
				echo json_encode($req);
			}
			/*


			else if ($section == 'toys'){
			}
			exit;


		}
		*/
			exit;


		} else if (isset($_GET['SECTION'])) {	
		$section = $_GET['SECTION'];


		if(isset($_POST['add_data'])){
			$req = false; // изначально переменная для "ответа" - false
		  	parse_str($_POST['add_data'], $add_data); // разбираем строку запроса
		  	// Приведём полученную информацию в удобочитаемый вид
		  	ob_start(); 

		  	/*if (empty($_FILES['photo'])) {
		  		echo "no photo";
		  	}*/
		  	/*if(isset($_FILES) && $_FILES['photo']['error'] == 0){ // Проверяем, загрузил ли пользователь файл
				$destiation_dir = dirname(__FILE__) .'/'.$_FILES['photo']['name']; // Директория для размещения файла
				move_uploaded_file($_FILES['photo']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
				echo 'File Uploaded'; // Оповещаем пользователя об успешной загрузке файла
			}else{
				echo 'No File Uploaded'; // Оповещаем пользователя о том, что файл не был загружен
			}*/



				$sql = "select * from `$section`";
				$result = mysqli_query($is_connected, $sql);


				$query = "insert into $section (";
				foreach ($add_data as $key => $value) {
					if ($key == 'ID') {
						
					}else{
						$query .= $key.", ";

					}

				}
				$query = substr($query, 0, -2);
				$query .= ") values (";

				foreach ($add_data as $key => $value) {
					$info = mysqli_fetch_field($result);

					/*echo "<pre>";
					print_r($info);
					echo "</pre>";*/

					switch ($info->type) {
						case 3:
							$type = 'number';
							$str = '';
							break;
						case 253:
							$type = 'text';
							$str = '\'';
							break;
						case 252:
							$type = 'file';
							break;
						
						default:
							# code...
							break;
					}

					if ($key == 'ID') {
						
					}else{
						//echo "$info->type $key $value<br>";
						$query .= $str.$value.$str.', ';

					}
				}
				$query = substr($query, 0, -2);
				$query .= ")";
				echo "$query";

				/*echo "<pre>";
				print_r($add_data);
				echo "</pre>";*/
				

				$result = mysqli_query($is_connected, $query);

				if ($result) {
					echo "Товар добавлен";
				}

			  	$req = ob_get_contents();
		  	ob_end_clean();
		  	echo json_encode($req); // вернем полученное в ответе
		  	exit;
		}

		if(isset($_POST['update_data'])){
			$req = false; // изначально переменная для "ответа" - false
		  	parse_str($_POST['update_data'], $update_data); // разбираем строку запроса
		  	// Приведём полученную информацию в удобочитаемый вид

				$id = $update_data['ID'];
		  		//echo "$id";

		  	ob_start(); 


		  	echo "<pre>";
				print_r($update_data);
				echo "</pre>";

				$sql = "select * from `$section`";
				$result = mysqli_query($is_connected, $sql);


				$query = "update `$section` set ";
				foreach ($update_data as $key => $value) {
					if ($key == 'ID') {
						
					}else{
						$query .= $key."=";

					}

					$info = mysqli_fetch_field($result);

					switch ($info->type) {
						case 3:
							$type = 'number';
							$str = '';
							break;
						case 253:
							$type = 'text';
							$str = '\'';
							break;
						case 252:
							$type = 'file';
							break;
						
						default:
							# code...
							break;
					}

					if ($key == 'ID') {
						
					}else{
						$query .= $str.$value.$str.', ';

					}

				}
				$query = substr($query, 0, -2);
				$query .= " where ID=$id";

				echo "$query";

				
				

				$result = mysqli_query($is_connected, $query);

				if ($result) {
					echo "Товар изменен";
				}

			  	$req = ob_get_contents();
		  	ob_end_clean();
		  	echo json_encode($req); // вернем полученное в ответе
		  	exit;
		}


		//echo json_encode($section);
		


		if (isset($_GET['MANIPULATE'])) {
			$manipulate = $_GET['MANIPULATE'];

			if (isset($_GET['SECTION'])) {
				$section = $_GET['SECTION'];
			}

			/*echo json_encode($section
		);*/

			switch ($manipulate) {
				case 1:
					$query = "select * from `$section`";
					$result = mysqli_query($is_connected, $query);
					ob_start();
						addProduct($result, $is_connected);
						$req = ob_get_contents();
					ob_clean();

					echo json_encode($req);
				break;
				case 2:
					$id = $_GET['ID'];

					$query = "delete from `$section` WHERE `ID` = $id";
					$result = mysqli_query($is_connected, $query);
					ob_start();
						if ($result) {
							echo "Товар удален";
						}
					
						$req = ob_get_contents();
					ob_clean();
					echo json_encode($req);

				break;
				case 3:
					$id = $_GET['ID'];

					if ($section == 'pets'){

						$query = "select `ID`, `breed`, `age`, pets.`name`, `gender`, `price`, `photo`, `breeds`.pet from `pets` left join `breeds` on `breed`=breeds.name where ID = $id";
						$result = mysqli_query($is_connected, $query);
						
						ob_start();
							updateForm($result, $section, $id, $is_connected);
							$req = ob_get_contents();

						ob_end_clean();
						//echo json_encode($req);

					} else if ($section == 'nutrition'){

						$query = "select * from `$section` where ID = $id";
						$result = mysqli_query($is_connected, $query);
						
						ob_start();
							updateForm($result, $section, $id, $is_connected);
							$req = ob_get_contents();

						ob_end_clean();
					}else if ($section == 'toys'){

						$query = "select * from `$section` where ID = $id";
						$result = mysqli_query($is_connected, $query);
						
						ob_start();
							updateForm($result, $section, $id, $is_connected);
							$req = ob_get_contents();

						ob_end_clean();
					}
					
					echo json_encode($req);
				break;
				
				default:
					# code...
					break;
			}
		}else{
			switch ($section) {
			case 'pets':
				$query = "select `ID`, `breed`, `age`, pets.`name`, `gender`, `price`, `photo`, `breeds`.pet from `pets` left join `breeds` on `breed`=breeds.name";
				$result = mysqli_query($is_connected, $query);
				
				//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);			  	
				//header('Content-type: image/jpeg; charset=utf-8');
				//echo $row['photo'];
				$count = 0;

				ob_start();							

					addAdminPanel($is_connected, $result, null, 'add');



					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						if ($count % 3 === 0) {
							echo "<div class='wrap'>";
						
						}
						echo "<div class='card'>";


						addAdminPanel($is_connected, $result, $row['ID']);
						//echo "<script>console.log('$count')</script>";
						if ($row['photo']) {
							echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo']).'"/>';
						}

						echo "<div class='description'>";
						echo "<p>".$row['pet']."</p>";
						echo "<p>Порода: ".$row['breed']."</p>";

						if ($row['name'] == '0') {
							echo "<p>Кличка: нет</p>";
						}else{
							echo "<p>Кличка: ".$row['name']."</p>";

						}
						echo "<p>Возраст: ".$row['age']."</p>";

						if ($row['gender'] == 'f') {
							echo "<p>Пол: <button class='gender f'></button></p>";
						}else if($row['gender'] == 'm') {
							echo "<p>Пол: <button class='gender m'></button></p>";

						}else{
							/*echo "fsl;";*/
						}
						echo "</div>";//description

						addUserPanel($row['ID'], "add");
						
						echo "</div>";//card
						$count++;
						if ($count % 3 === 0) {
							echo "</div>";//wrap
						}

					}



					$req = ob_get_contents();


				ob_end_clean();
				echo json_encode($req);
				break;

			case 'nutrition':

				$query = "select * from `$section`";

				$result = mysqli_query($is_connected, $query);

				//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);			  	
				//header('Content-type: image/jpeg; charset=utf-8');
				//echo $row['photo'];
				$count = 0;
				//$countNum = mysqli_num_rows($result);

				ob_start();

					addAdminPanel($is_connected, $result, null, 'add');

					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						if ($count % 3 === 0) {
							echo "<div class='wrap'>";
						}
						echo "<div class='card'>";
						
						addAdminPanel($is_connected, $result, $row['ID']);

						echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>';
						echo "<div class='description'>";
						echo "<p>Тип: ".$row['type']."</p>";

						echo "<p> ".$row['name']."</p>";
						echo "<p>Вес: ".$row['weight']."</p>";
						echo "<p>Цена: ".$row['price']."</p>";
						echo "<p>Для: ".$row['forWhom']."</p>";
						
						if (isset($_SESSION['userStatus'])) {
							if ($_SESSION['userStatus'] == 1) {
								echo "<p>На складе: ".$row['amount']."</p>";
							}
						}
						
						//echo "<script>console.log('$countNum')</script>";
						
						echo "</div>";

						addUserPanel($row['ID'], "add");

						
						echo "</div>";
						$count++;
						if ($count % 3 === 0) {
							echo "</div>";
						}

					}

					$req = ob_get_contents();


				ob_end_clean();
				echo json_encode($req);
				
				//echo json_encode('f');
				break;
			case 'toys':
				$query = "select * from `$section`";

				$result = mysqli_query($is_connected, $query);

				//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);			  	
				//header('Content-type: image/jpeg; charset=utf-8');
				//echo $row['photo'];
				$count = 0;
				//$countNum = mysqli_num_rows($result);

				ob_start();
		
					addAdminPanel($is_connected, $result, null, 'add');

					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						if ($count % 3 === 0) {
							echo "<div class='wrap'>";
						}
						echo "<div class='card'>";
						
						addAdminPanel($is_connected, $result, $row['ID']);

						echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>';
						echo "<div class='description'>";

						echo "<p> ".$row['name']."</p>";
						echo "<p>Цена: ".$row['price']."</p>";
						echo "<p>Для: ".$row['forWhom']."</p>";

						if (isset($_SESSION['userStatus'])) {
							if ($_SESSION['userStatus'] == 1) {
								echo "<p>На складе: ".$row['amount']."</p>";
							}
						}
						
						//echo "<script>console.log('$countNum')</script>";
						
						echo "</div>";

						addUserPanel($row['ID'], "add");

						
						echo "</div>";
						$count++;
						if ($count % 3 === 0) {
							echo "</div>";
						}

					}

					$req = ob_get_contents();


				ob_end_clean();
				echo json_encode($req);
				break;
			
			default:
				# code...
				break;
		}
	}
	}
	//echo json_encode($section);

	function selectBreeds($is_connected){
		$query = "select * from `breeds`";
		$result = mysqli_query($is_connected, $query);
		echo "<select name='breed'>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option>";
			echo $row['name'];
			echo "</option>";
		}
		echo "</select>";
			
	}


	function addProduct($array, $is_connected){
		$i = 0;
		while ($info = mysqli_fetch_field($array)) {
			if ($i < $array->field_count) {
				//echo "$nameIn";

				$nameIn = $info->name;

				switch ($info->type) {
					case 3:
						$type = 'number';
						//$val = $row[$i];
						break;
					case 253:
						$type = 'text';
						//$val = $row[$i];
						break;
					case 252:
						$type = 'file';
						//$val = '';
						//$val = $row[$i];
						break;
					
					default:
						# code...
						break;
				}



				//echo "$nameIn";
				if ($nameIn == 'gender') {
					
					echo "<p><input type='radio' name='$nameIn' value='f'>
							<button class='gender f'></button>
						</p>";
					echo "<p><input type='radio' name='$nameIn' value='m'>
							<button class='gender m'></button>
						</p>";
				}else if ($nameIn == 'breed') {
					selectBreeds($is_connected);

				}else{
					echo "<input type='$type' name='$nameIn' placeholder='$nameIn'>";

				}

				//echo "<input type='text' name='$nameIn' value='$val'>";
				//echo "<input type='text' name='$nameIn' placeholder='$nameIn'>";
				$i++;
				
			}
			
		}
		echo "<input type='submit' name='addProduct' value='Добавить' class='button'>";
		mysqli_data_seek($array, 0);
	}

	function addAdminPanel($is_connected, $array, $id = "none", $class = "other")
	{
		if (isset($_SESSION['userStatus'])) {
			if ($_SESSION['userStatus'] == 1) {
			
				if ($class == 'add') {

					echo "<div class='adminPanel'>
							<button class='addBut' id='add_product'>Добавить товар</button>
							<button class='addBut' id='add_breed'>Добавить породу</button>
							<button class='addBut' id='add_pet'>Добавить название животного</button>
							<button class='addBut' id='add_nutrition_name'>Добавить тип корма</button>
							<div class='modal_background add'>
								<div class='modal_form'>
									<button type='button' class='close_form' >X</button>
									<form enctype='multipart/form-data' accept='image/*,image/jpeg' action='catalog.php' method='POST' id='add_form'>";

					$i = 0;
						
					addProduct($array, $is_connected);

					echo "</form></div></div></div>";//class='adminPanel'



				mysqli_data_seek($array, 0);

				
				}else{
					echo "<div class='adminPanel' data-id='$id'><button class='delete'>Удалить</button>";
					echo "<button class='updateBut'>Изменить</button></div>";
				}
			}
		}
	}

	function addUserPanel($id = "none", $class = "other")
	{
		if (isset($_SESSION['userStatus'])) {
			if ($_SESSION['userStatus'] == 0) {
			
				if ($class == 'add') {
					echo "<div class='userPanel' data-id='$id'>
						<button class='buy'>Купить</button>
						</div>";
				}
			}
		}
	}

	function updateForm($array, $section, $id, $is_connected){
			

		//$result = mysqli_query($is_connected, $query);


		$i = 0;

		$row = mysqli_fetch_row($array);
		//$row2 = $row;	
		//echo "<pre>";
		//print_r($array);
		//echo $array -> num_rows;
		//echo "</pre>";

		mysqli_data_seek($array, 0);

			
		while ($info = mysqli_fetch_field($array)) {
			if ($i < $array->field_count) {
				$nameIn = $info->name;


				echo "<pre>";
				//print_r($info);
				echo "</pre>";
				

				//$query .= $nameIn."=".$val.", ";
				switch ($info->type) {
					case 3:
						$type = 'number';
						$val = trim($row[$i]);
						break;
					case 253:
						$type = 'text';
						$val = trim($row[$i]);
						break;
					case 252:
						$type = 'file';
						//$val = '';
						//$val = $row[$i];
						break;
					
					default:
						# code...
						break;
				}

				if ($nameIn == 'ID') {
					echo "<input type='$type' name='$nameIn' value='$val' readonly>";
				}else if ($nameIn == 'gender') {
					if ($val == 'f') {
						echo "<p><input type='radio' name='$nameIn' value='f' checked>
								<button class='gender f'></button>
							</p>";
						echo "<p><input type='radio' name='$nameIn' value='m'>
								<button class='gender m'></button>
							</p>";
						
					}else if ($val == 'm') {
						echo "<p><input type='radio' name='$nameIn' value='f'>
								<button class='gender f'></button>
							</p>";					
						echo "<p><input type='radio' name='$nameIn' value='m' checked>
								<button class='gender m'></button>
							</p>";
					} else{
						echo "<p><input type='radio' name='$nameIn' value='f'>
								<button class='gender f'></button>
							</p>";
						echo "<p><input type='radio' name='$nameIn' value='m'>
								<button class='gender m'></button>
							</p>";
					}
				}else if ($nameIn == 'breed') {
					selectBreeds($is_connected);

				}else{
					echo "<input type='$type' name='$nameIn' value='$val'>";

				}

				//echo "<input type='text' name='$nameIn' value='' placeholder='$nameIn'>";
				$i++;
				
			}
			
		}

		//$query .= "where ID=$id";
		
		//echo "$query";
		echo "<input type='submit' name='updateProduct' value='Изменить' class='button'>";
		


	mysqli_data_seek($array, 0);
	}



	



?>