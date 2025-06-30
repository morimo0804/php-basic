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
  </head>
  <body>

<?php
require_once('../common/common.php');
?>

   ダウンロードしたい注文日を選んでください。<br/>
   <form method="post" action="order_download_done.php">
    <?php pulldown_year(); ?>
    年
    <?php pulldown_month(); ?>
    月
    <?php pulldown_day(); ?>
    日<br/>
    <br/>
    <input type="submit" value="ダウンロードへ">
   </form>
   <br>
   <a class="btn" href="../staff_login/staff_top.php">戻る</a>

  </body>
</html>
