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
   <h1>ログアウトしました。</h1><br/>
   <br/>
   <a class="btn" href="../staff_login/staff_login.html">ログイン画面へ</a>
  </body>
</html>
