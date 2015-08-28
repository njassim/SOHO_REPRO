<?php
include './admin/config.php';
include './admin/db_connection.php';

$user_id            =       $_POST['user_id'];
$company_id         =       $_POST['comp_id'];
$reference          =       $_POST['search'];

$auto_ref           =       AutoRef($company_id, $reference);
if(count($auto_ref) > 0){
?>   
<ul class="auto_reference">
<?php
foreach ($auto_ref as $ref){
?>
    <li><span onclick="return get_reference('<?php echo $ref['reference']; ?>','<?php echo $ref['id']; ?>','<?php echo $ref['company_id']; ?>');"><?php echo $ref['reference']; ?></span></li>
<?php
}
?>
</ul>
<?php
}
