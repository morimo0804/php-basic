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
  max-width: 600px;
  margin: 40px auto;
  padding: 30px;
  background-color: #fafafa;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-family: 'Arial', sans-serif;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  align-items: center;
  gap: 20px;
}

.form-group label {
  width: 120px;
  font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="file"] {
  flex: 1;
  padding: 6px 10px;
  font-size: 15px;
}

.price-wrapper {
  display: flex;
  align-items: center;
  gap: 5px;
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
  <h1>商品追加</h1>
<form method="post" action="pro_add_check.php" enctype="multipart/form-data" class="form-container">
  <div class="form-group">
    <label>商品名を入力</label>
    <input type="text" name="name">
  </div>

  <div class="form-group">
    <label>価格を入力</label>
    <div class="price-wrapper">
      <input type="text" name="price">
      <span>円</span>
    </div>
  </div>

  <div class="form-group">
    <label>画像を選択</label>
    <input type="file" name="gazou">
  </div>

  <div class="form-buttons">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </div>
</form>

</body>
</html>