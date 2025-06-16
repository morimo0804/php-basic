<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print'ログインされていません。<br/>';
  print'<a href="shop_list.php">商品一覧へ</a>';
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css">
    <style>
      .info-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 400px;
        margin: 20px auto;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f9f9f9;
      }

      .info-item {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
        padding-bottom: 6px;
      }

      .label {
        font-weight: bold;
        color: #333;
      }

      .value {
        width: 60%;
        color: #444;
        text-align: right;
      }
    </style>
  </head>
  <body>
   <?php

    $code=$_SESSION['member_code'];

    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT name,email,postal1,postal2,address,tel FROM dat_member WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$code;
    $stmt->execute($data);
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

    $dbh=null;

    $onamae=$rec['name'];
    $email=$rec['email'];
    $postal1=$rec['postal1'];
    $postal2=$rec['postal2'];
    $address=$rec['address'];
    $tel=$rec['tel'];

    print '<div class="info-container">';
    print '<div class="info-item"><div class="label">お名前</div><div class="value">' . $onamae . '</div></div>';
    print '<div class="info-item"><div class="label">メールアドレス</div><div class="value">' . $email . '</div></div>';
    print '<div class="info-item"><div class="label">郵便番号</div><div class="value">' . $postal1 . '-' . $postal2 . '</div></div>';
    print '<div class="info-item"><div class="label">住所</div><div class="value">' . $address . '</div></div>';
    print '<div class="info-item"><div class="label">電話番号</div><div class="value">' . $tel . '</div></div>';
    print '</div>';

    print '<form method="post" action="shop_kantan_done.php">';
    print '<input type="hidden" name="onamae" value="' . $onamae . '">';
    print '<input type="hidden" name="email" value="' . $email . '">';
    print '<input type="hidden" name="postal1" value="' . $postal1 . '">';
    print '<input type="hidden" name="postal2" value="' . $postal2 . '">';
    print '<input type="hidden" name="address" value="' . $address . '">';
    print '<input type="hidden" name="tel" value="' . $tel . '">';
    print '<div class="buttons">';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK">';
    print '</div>';
    print '</form>';

   ?>
  </body>
</html>
