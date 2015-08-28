<?php
include './admin/config.php';

        $q          =   $_GET['q'];	
        $my_data    =   mysql_real_escape_string($q);
	$sql="SELECT comp_name FROM sohorepro_company WHERE comp_name LIKE '%$my_data%' ORDER BY comp_name";
	$result = mysql_query($sql);	
	if($result)
	{
		while($row=mysql_fetch_array($result))
		{
			echo $row['comp_name']."\n";
		}
	}
?>