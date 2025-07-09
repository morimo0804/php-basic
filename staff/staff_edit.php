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
  <style>
    .form-container {
  max-width: 500px;
  margin: 40px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-family: sans-serif;
  display: flex;
  flex-direction: column;
  gap: 15px;
  background-color: #dde9ea;
}

.form-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

.form-group label {
  width: 150px;
  font-weight: bold;
  font-size: 15px;
}

.form-group input {
  flex: 1;
  padding: 5px 8px;
  font-size: 14px;
}

.form-buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.form-buttons input {
  padding: 8px 20px;
  font-size: 14px;
  cursor: pointer;
}

.center{
  display: flex;
  justify-content: center;
}
  </style>
</head>
<body>
<?php

try{
  $staff_code=$_GET['staffcode'];

  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='root';
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql='SELECT name FROM mst_staff WHERE code=?';
  $stmt=$dbh->prepare($sql);
  $data[]=$staff_code;
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);
  $staff_name=$rec['name'];

  $dbh=null;
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

<h1>スタッフ修正</h1>
<br/>
<div class="form-group center">
  <label>スタッフコード</label>
  <div class="value"><?php print $staff_code; ?></div>
</div>
<form method="post" action="staff_edit_done.php" class="form-container">
  <input type="hidden" name="code" value="<?php print $staff_code; ?>">

  <div class="form-group">
    <label for="name">スタッフ名</label>
    <input type="text" id="name" name="name" value="<?php print $staff_name; ?>">
  </div>

  <div class="form-group">
    <label for="pass">パスワード</label>
    <input type="password" id="pass" name="pass">
  </div>

  <div class="form-group">
    <label for="pass2">パスワード（確認）</label>
    <input type="password" id="pass2" name="pass2">
  </div>

  <div class="form-buttons">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </div>

</body>
</html>