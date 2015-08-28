<?php
if (isset($_POST['orders'])) {
	
	$orders = explode('&', $_POST['orders']);
	$array = array();
	$comp_id_order  = $_POST['comp_id'];
	foreach($orders as $item) {
		$item = explode('=', $item);
		$item = explode('_', $item[1]);
		$array[] = $item[1];
	}
	
	try {

		$objDb = new PDO('mysql:host=localhost;dbname=supply.sohorepro.com', 'root', '');
		$objDb->exec("SET CHARACTER SET utf8");
		
		foreach($array as $key => $value) {
			$key = $key;
			$sql = "UPDATE `sohorepro_favorites` 
					SET `sort_id` = ?
					WHERE `id` = ? AND comp_id = '".$comp_id_order."'";
			
			$objDb->prepare($sql)->execute(array($key, $value));		
		}
		
		echo json_encode(array('error' => false));
	
	} catch(Exception $e) {
	
		echo json_encode(array('error' => true));
		
	}
	
} else {
	echo json_encode(array('error' => true));
}