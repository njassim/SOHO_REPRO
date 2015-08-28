<?php
if (isset($_POST['orders'])) {
	
	$orders = explode('&', $_POST['orders']);
	$array = array();
        
        array_pop($orders);
        
//        echo '<pre>';
//        print_r($orders);
//        echo '</pre>';
//        exit;
        
        $super_id_dnd    = ($_POST['super_id_dnd'] != '0') ? $_POST['super_id_dnd'] : '' ;
        $cat_id_dnd      = ($_POST['cat_id_dnd'] != '0') ? $_POST['cat_id_dnd'] : '' ;
        $sub_id_dnd      = ($_POST['sub_id_dnd'] != '0') ? $_POST['sub_id_dnd'] : '' ;
        
        
	
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
			$sql = "UPDATE `sohorepro_products` 
					SET `sort` = ?
					WHERE `id` = ? AND supercategory_id = '".$super_id_dnd."' AND category_id = '".$cat_id_dnd."' AND subcategory_id = '".$sub_id_dnd."' ";
			
			$objDb->prepare($sql)->execute(array($key, $value));		
		}
		
		echo json_encode(array('error' => false));
	
	} catch(Exception $e) {
	
		echo json_encode(array('error' => true));
		
	}
	
} else {
	echo json_encode(array('error' => true));
}
