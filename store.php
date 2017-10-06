<?php

require('functions.php');

$res = checkReferer();
if($res != 'back'){
  header('location: ./index.php');
}elseif($res == 'index'){
  header('location: ./index.php');
}else{
  header('location: '.$_SERVER['HTTP_REFERER'].'');
}
?>
