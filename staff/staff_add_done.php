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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ろくまる農園</title>
  <link rel="stylesheet" href="../css/global.css">
</head>
<body>
<?php
try{

    require_once('../common/common.php');

    $post=sanitize($_POST);
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='INSERT INTO mst_staff(name,password) VALUES (?,?)';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_name;
    $data[]=$staff_pass;
    $stmt->execute($data);

    $dbh = null;

    print'<br/>';
    print$staff_name;
    print'さんを追加しました。<br/>';
     print'<br/>';

}
catch(Exception $e){
     print'ただいま障害により大変ご迷惑をお掛けしております。';
     print $e->getMessage();
     exit();
}
?>

<a class="btn" href="staff_list.php">戻る</a>
</body>
</html>