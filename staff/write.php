<title>Vowels Count</title>
<?php
session_start();
// store session data
$_SESSION['name']='jassim';
//$number = 9;
//$str = "Beijing";
//$file = fopen("test.txt","w");
//echo fprintf($file,"There are %u million bicycles in %s.",$number,$str).'<br>';


function countWord($str) {
    
    $value = substr_count($str, 'a') + substr_count($str, 'e') +
            substr_count($str, 'i') + substr_count($str, 'o') +
            substr_count($str, 'u');

    return $value;
}

$str = "N Mohamed Jassim";
$check = countWord($str);
echo $check . ' is total count</br>';

echo $_SESSION['name'];
?>
