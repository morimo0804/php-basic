<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print'ようこそゲスト様　';
  print'<a href="member_login.html">会員ログイン</a><br/>';
  print'<br/>';
 } else{
   print'ようこそ';
   print'<span>';
   print$_SESSION['member_name'];
   print'</span>';
   print'様　';
   print'<a href="member_logout.php">ログアウト</a><br/>';
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
    span {
  font-weight: bold;
}

.product-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    margin: 30px 0 30px;
  }

  .product-card {
    width: 200px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    background-color: #f9f9f9;
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
    color: #888;
  }

  .cart-link {
    display: block;
    margin-top: 2rem;
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

    $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
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
    print '<div class="product-name">' . $rec['name'] . '</div>';
    print '<div class="product-price">' . $rec['price'] . '円</div>';
    print '</a>';
    print '</div>';
    }

    print'</div>';
    print'<a href="shop_cartlook.php">カートを見る</a><br/>';
}
catch(Exception $e){
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>
</body>
</html>