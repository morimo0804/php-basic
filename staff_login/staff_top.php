<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
  print'ログインされていません。<br/>';
  print'<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
 } else{
   print$_SESSION['staff_name'];
   print'さんログイン中';
   print'<br/>';
 }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css">
    <style>
      .margin{
        margin-left: 30px;
      }
    </style>
  </head>
  <body>
   <h1>ショップ管理トップメニュー</h1><br />
    <br />
    <div class="flex">
      <a class="btn margin" href="../staff/staff_list.php">スタッフ管理</a>
       <a class="btn" href="../product/pro_list.php">商品管理</a>
      <a class="btn" href="../order/order_download.php">注文ダウンロード</a>
    </div>
    <br>
     <a class="btn" href="staff_logout.php">ログアウト</a><br/>
  </body>
</html>
