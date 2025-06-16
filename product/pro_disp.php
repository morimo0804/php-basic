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
  max-width: 400px;
  margin: 40px auto;
  padding: 20px 40px;
  border: 1px solid #ccc;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
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

.product-item.image {
  justify-content: center;
   border: none;
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
  $pro_gazou_name=$rec['gazou'];

  $dbh=null;

  if($pro_gazou_name==''){
    $disp_gazou='';
  } else{
    $disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
  }
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

<h1>商品情報参照</h1>
<div class="product-detail">
  <div class="product-item">
    <span class="label">商品コード</span>
    <span class="value"><?php print $pro_code; ?></span>
  </div>

  <div class="product-item">
    <span class="label">商品名</span>
    <span class="value"><?php print $pro_name; ?></span>
  </div>

  <div class="product-item">
    <span class="label">価格</span>
    <span class="value"><?php print $pro_price; ?>円</span>
  </div>

  <div class="product-item image">
    <?php print $disp_gazou; ?>
  </div>
</div>
<form>
    <input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>