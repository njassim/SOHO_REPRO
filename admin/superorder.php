<?php
if (isset($_POST['orders'])) {
	
	$orders = explode('&', $_POST['orders']);
	$array = array();
	
	foreach($orders as $item) {
		$item = explode('=', $item);
		$item = explode('_', $item[1]);
		$array[] = $item[1];
	}
	
	try {

		$objDb = new PDO('mysql:host=localhost;dbname=sohorepro', 'sohoadmin', 'R3pr0gr@fx2013');
		$objDb->exec("SET CHARACTER SET utf8");
		
		foreach($array as $key => $value) {
			$key = $key + 1;
			$sql = "UPDATE `sohorepro_category` 
					SET `sort` = ?
					WHERE `id` = ? AND super_id = '0'";
			
			$objDb->prepare($sql)->execute(array($key, $value));		
		}
		
		echo json_encode(array('error' => false));
	
	} catch(Exception $e) {
	
		echo json_encode(array('error' => true));
		
	}
	
} else {
	echo json_encode(array('error' => true));
}