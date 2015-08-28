<?php
    $www_root = 'http://localhost/sohorepro/admin/img';
    $dir = '/var/www/sohorepro/admin/img';
    $file_display = array('jpg', 'jpeg', 'png', 'gif');
    $height = '250';
    $width   = '500';
    if ( file_exists( $dir ) == false ) {
       echo 'Directory \'', $dir, '\' not found!';
    } else {
       $dir_contents = scandir( $dir );

        foreach ( $dir_contents as $file ) {
           $file_type = strtolower( end( explode('.', $file ) ) );
           if ( ($file !== '.') && ($file !== '..') && (in_array( $file_type, $file_display)) ) {
              echo '<img src="', $www_root, '/', $file, '" alt="', $file, '" title="', $file, '" height="', $height,'"  width="', $width,'" />';
              echo '</br>';
              echo '</br>';
           }
        }
    }
?>
