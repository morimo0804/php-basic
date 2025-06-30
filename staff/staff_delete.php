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
    .product-detail {
  max-width:400px;
  margin: 40px auto;
  padding: 20px 40px;
  border: 1px solid #ccc;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
  background-color: #dde9ea;
}

.product-item {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 300px;
  justify-content: flex-start;
  border-bottom: 1px solid #ccc;
}

.label {
  width: 120px;
  font-weight: bold;
  font-size: 16px;
  text-align: left;
  margin-right: 10px;
}

.value {
  font-size: 16px;
  text-align: right;
  flex: 1;
}

.form-buttons {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-top: 20px;
}

.form-buttons input {
  padding: 8px 20px;
  font-size: 16px;
  border-radius: 5px;
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

<h1>スタッフ削除</h1>
<div class="product-detail">
  <div class="product-item">
    <span class="label">スタッフコード</span>
    <span class="value"><?php print $staff_code; ?></span>
  </div>

  <div class="product-item">
    <span class="label">スタッフ名</span>
    <span class="value"><?php print $staff_name; ?></span>
  </div>
</div>
このスタッフを削除してよろしいですか？<br/>
<form method="post" action="staff_delete_done.php">
  <input type="hidden" name="code" value="<?php print $staff_code; ?>">
     <div class="form-buttons">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </div>
</form>

</body>
</html>