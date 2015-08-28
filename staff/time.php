<?php
$current_timne = date("Y-m-d h:i:s");
$date = new DateTime($current_timne, new DateTimeZone('America/New_York'));
date_default_timezone_set('America/New_York');
$temp_time =  date("Y-m-d h:iA", $date->format('U'));
$datetime_from = date("h:i",strtotime("-90 minutes",strtotime($temp_time)));


echo $datetime_from;


// 2012-07-05 10:43AM
?>