<?php
include './config.php';

$queryString = $_POST['queryString'];
$queryString = mysql_real_escape_string($queryString);
        
            if(strlen($queryString) >0) {
                
                $query =("SELECT comp_name FROM sohorepro_company WHERE comp_name LIKE '%$queryString%' ORDER BY comp_name");
                $result = mysql_query($query);
                $affectedRows=mysql_affected_rows();
                if ($affectedRows==0){
    
                    echo '<center>There is no Record </center>';
                    }
                    else{
                        ?>
<ul class="autoload">
<?php
                while($row1 = mysql_fetch_array($result))
                      {
                    
                         echo '<li onClick="fill(\''.$row1[0].'\');">'.$row1[0].'</li>';
                     }
                     ?>
</ul>
<?php
                } 
        
                
            }
            
?>
