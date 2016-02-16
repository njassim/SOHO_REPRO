<?php
//$str = "&lt;a href='http://premiumincentive.com/pdf/nda_548.pdf'&gt;A link&lt;/a&gt;";
//echo html_entity_decode($str);

$string = "&lt;a href='http://premiumincentive.com/pdf/nda_548.pdf'&gt;A link&lt;/a&gt;";
$output = mb_convert_encoding($string, 'UTF-8', 'HTML-ENTITIES');
echo $output;