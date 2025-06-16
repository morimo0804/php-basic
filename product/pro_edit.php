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

.image-preview {
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

.center{
  justify-content: center;
}
</style>
</head>
<body>
<?php

try{
  $pro_code=$_GET['procode'];

  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='root';
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
  $stmt=$dbh->prepare($sql);
  $data[]=$pro_code;
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);
  $pro_name=$rec['name'];
  $pro_price=$rec['price'];
  $pro_gazou_name_old=$rec['gazou'];

  $dbh=null;

  if($pro_gazou_name_old==''){
    $disp_gazou='';
  } else{
    $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
  }
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

<h1>商品修正</h1>
<br/>
<div class="form-group center">
  <label>商品コード</label>
  <div class="value"><?php print $pro_code; ?></div>
</div>
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data" class="form-container">
  <input type="hidden" name="code" value="<?php echo $pro_code; ?>">
  <input type="hidden" name="gazou_name_old" value="<?php echo $pro_gazou_name_old; ?>">

  <div class="form-group">
    <label>商品名</label>
    <input type="text" name="name" value="<?php echo $pro_name; ?>">
  </div>

  <div class="form-group">
    <label>価格</label>
    <div class="price-wrapper">
      <input type="text" name="price" value="<?php echo $pro_price; ?>">
      <span>円</span>
    </div>
  </div>

  <div class="form-group">
    <label>現在の画像</label>
    <?php print $disp_gazou; ?>
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