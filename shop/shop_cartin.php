<?php
session_start();
session_regenerate_id(true);

$member_message = '';

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
  </style>
</head>
<body>
<?php

try{
  $pro_code=$_GET['procode'];

  if(isset($_SESSION['cart'])==true){
    $cart=$_SESSION['cart'];
    $kazu=$_SESSION['kazu'];
    if(in_array($pro_code,$cart)==true){
      print'その商品はすでにカートに入っています。<br/><br/>';
      print'<a class="btn" href="shop_list.php">商品一覧へ戻る</a>';
      exit();
    }
  }
  $cart[]=$pro_code;
  $kazu[]=1;
  $_SESSION['cart']=$cart;
  $_SESSION['kazu']=$kazu;
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

カートに追加しました。<br/>
<br/>
<a class="btn" href="shop_list.php">商品一覧に戻る</a>

</body>
</html>