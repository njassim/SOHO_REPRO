<form action="test.php">
    <input name="tt" value="1" type="hidden" />
<table align="center" border="1">
    <tr>
        <td>S.No</td>
        <td>Product Name</td>
        <td>Quantity</td>
        <td>Price</td>
    </tr>
<?php

    $i = 1;
    for($j = 0; $j < count($_REQUEST['product_id']); $j++){
       if ($_REQUEST['quantity'][$j] != '') { 
           ?>
      <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $_REQUEST['product_name'][$j]; ?></td>
          <td><input type="text" name="qty" style="width: 30px;" value="<?php echo $_REQUEST['quantity'][$j]; ?>" /></td>
          <td><?php echo $_REQUEST['price'][$j]; ?></td>
     </tr>
      <?php 
      $i++;
       }      
    }
?>
     <tr align="right">
         <td colspan="4"><input type="submit" value="Submit" /></td>
     </tr>
</table>
    
    </form>

