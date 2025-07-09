<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print'ようこそゲスト様　';
  print'<a href="member_login.html" class="login-button">会員ログイン</a><br/>';
  print'<br/>';
 } else{
   print'ようこそ';
   print'<span>';
   print$_SESSION['member_name'];
   print'</span>';
   print'様　';
   print'<a href="member_logout.php" class="logout-button">ログアウト</a><br/>';
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
    .login-button,
.logout-button {
  display: inline-block;
  padding: 8px 15px;
 background-color: #28a745;
  color: #fff;
  text-align: center;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.login-button:hover,
.logout-button:hover {
  background-color: #218838;
}

.login-button {
  margin-left: 10px;
}

    span {
      font-weight: bold;
    }

    .box{
      width: 100%;
      max-width: 200px;
      margin-left: auto;
      margin-right: auto;
    }

    .flex{
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .block{
      display: block;
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
    $disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
  }
  print'<a class="btn" href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br/><br/>';
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

<h1>商品情報参照</h1><br/>
<div class="box">
  <div class="flex border">
    <div class="block">商品コード</div>
    <?php print $pro_code; ?>
  </div>
  <div class="flex border">
    <div class="block">商品名</div>
    <?php print $pro_name; ?>
  </div>
  <div class="flex border">
    <div class="block">価格</div>
    <?php print $pro_price; ?>円
  </div>
  <?php print $disp_gazou; ?>
</div>
<form>
    <input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>