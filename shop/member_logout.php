<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()])==true){
  setcookie(session_name(),'',time()-42000,'/');
 }
 session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css">
  </head>
  <body>
   ログアウトしました。<br/>
   <br/>
   <a class="btn" href="shop_list.php">商品一覧へ</a>
  </body>
</html>
