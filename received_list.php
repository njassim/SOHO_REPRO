<?php
include './admin/config.php';
include './admin/db_connection.php';

function received_list() {
    $select_category = "SELECT * FROM sohorepro_mail_check ";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;    
}

$Received_Mail = received_list();
?>
<table align="center" width="960" border="1">
    <tr align="center">
    <td>S.N</td>
    <td>Name</td>
    <td>Mail</td>
    <td>Company</td>
    </tr>
    <?php 
    $i = 1;
    foreach ($Received_Mail as $received){ ?>
    <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $received['user_name']; ?></td>
    <td><?php echo $received['user_mail']; ?></td>
    <td><?php echo $received['company_name']; ?></td>
    </tr> 
    <?php 
    $i++;
    } 
    ?>
</table>