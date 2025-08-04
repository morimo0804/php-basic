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

.product-list {
     display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 2.3rem 1.8rem;
  margin: 30px auto;
  max-width: 1200px;
  }

  .product-card {
    width: 225px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 0 auto;
    padding: 1rem;
    background-color: #dde9ea;
    text-align: center;
    transition: box-shadow 0.3s ease;
  }

  .product-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .product-card a {
    text-decoration: none;
    color: #333;
    display: block;
  }

  .product-name {
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .product-price {
    color: #363636;
  }

  .cart-link {
    display: block;
    margin-top: 2rem;
  }

  .cart-item-count{
    position: absolute;
    top: -7px;
    right: -7px;
    background-color: red;
    color: #fff;
    border-radius: 50%;
    padding: 6px 8px;
    font-size: 14px;
    line-height: 1;
    min-width: 20px;
    text-align: center;
    box-sizing: border-box;
    z-index: 10;
  }

  .btn {
    position: relative;
  }

  .btn:hover {
    background-color: #0f6292;
  }

  .cart-empty {
      display: none;
  }
  </style>
</head>
<body>

<?php

try{
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT code, name, price, gazou FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    print'<h1>商品一覧</h1>';
    print '<div class="product-list">';

    while(true){
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
            break;
        }
       print '<div class="product-card">';
    print '<a href="shop_product.php?procode=' . $rec['code'] . '">';
    if ($rec['gazou'] != '') {
    $gazou_path = '../product/gazou/' . $rec['gazou'];
    print '<img src="' . $gazou_path . '" alt="' . $rec['name'] . '" style="max-width:100%; height:auto; margin-bottom: 10px;">';
  }
    print '<div class="product-name">' . $rec['name'] . '</div>';
    print '<div class="product-price">' . $rec['price'] . '円</div>';
    print '</a>';
    print '</div>';
    }

    print'</div>';
    print'<br/>';
   print'<div class="cart-container">';
print'<a class="btn point" href="shop_cartlook.php">カートを見る';
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $shop_items = count($cart);
} else {
    $shop_items = 0;
}
if ($shop_items >= 1) {
    print '<span class="cart-item-count">' . intval($shop_items) . '</span>';
} else {
    print '<span class="cart-item-count cart-empty"></span>';
}

print'</a>';
print'</div><br/>';
}
catch(Exception $e){
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>
</body>
</html>