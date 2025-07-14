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

    table {
      width: 80%;
      border-collapse: collapse;
      margin:0 auto 20px;
       border: 1px solid #ccc;
    }

    .table-header th {
    background-color: #1273ac;
    padding: 10px;
     border: 1px solid #ccc;
     color:#fff;
    }

    td {
      padding: 12px;
      text-align: center;
       border: 1px solid #ccc;
    }

    tr:nth-child(even) {
      background-color: #dde9ea;
    }

    img {
      max-width: 80px;
      height: auto;
    }

    input[type="text"] {
      width: 60px;
      padding: 4px;
      text-align: center;
    }

    .flex {
      display: flex;
      gap: 10px;
      justify-content: center;
    }
  </style>
</head>
<body>
<?php

try{

  if(isset($_SESSION['cart'])==true){
    $cart=$_SESSION['cart'];
    $kazu=$_SESSION['kazu'];
    $max=count($cart);
  } else{
    $max=0;
  }

  if($max==0){
    print'カートに商品が入っていません。<br/>';
    print'<br/>';
    print'<a class="btn" href="shop_list.php">商品一覧へ戻る</a>';
    exit();
  }

  $submit_type = $_POST['submit_type'] ?? '';

  // ===========================
  // 削除処理（チェックが入っている商品を削除）
  // ===========================
  if ($submit_type === "削除する") {
    for ($i = $max - 1; $i >= 0; $i--) {
      if (isset($_POST["sakujo{$i}"]) && $_POST["sakujo{$i}"] === "on") {
        array_splice($cart, $i, 1);
        array_splice($kazu, $i, 1);
      }
    }
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;
    header("Location: shop_cart.php");
    exit();
  }

  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='root';
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  foreach($cart as $key=>$val){
    $sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[0]=$val;
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

    $pro_name[]=$rec['name'];
    $pro_price[]=$rec['price'];
    if($rec['gazou']==''){
      $pro_gazou[]='';
    } else{
      $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
    }
  }
  $dbh=null;
}
catch(Exception $e){
  print'ただいま障害により大変ご迷惑をお掛けしております。';
   print 'エラー内容: ' . $e->getMessage();
    exit();
}
?>

<h1>カートの中身</h1><br/>
<form method="post" action="kazu_change.php">
  <table>
    <thead class="table-header">
    <tr>
      <th>商品</th>
      <th>商品画像</th>
      <th>価格</th>
      <th>数量</th>
      <th>小計</th>
      <th>削除</th>
    </tr>
  </thead>
  <tbody>
<?php for($i=0;$i<$max;$i++){
  ?>
  <tr>
    <td><?php print$pro_name[$i]; ?></td>
    <td><?php print$pro_gazou[$i]; ?></td>
    <td><?php print$pro_price[$i]; ?>円</td>
    <td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
    <td><?php print$pro_price[$i]*$kazu[$i]; ?>円</td>
    <td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
  </tr>
  <?php
}
?>
</tbody>
</table>
<input type="hidden" name="max" value="<?php print $max; ?>">
<div class="flex">
  <input type="submit" value="数量変更">
  <input type="submit" name="submit_type" value="削除する">
  <input type="button" onclick="history.back()" value="戻る">
</div>
</form>
<br/>
<a class="btn" href="shop_form.html">ご購入手続きへ進む</a><br/>
<br/>

<?php
if(isset($_SESSION["member_login"])==true){
  print'<a class="btn" href="shop_kantan_check.php">会員かんたん注文へ進む</a><br/>';
}
?>

</body>
</html>