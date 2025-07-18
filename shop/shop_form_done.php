<?php
  session_start();
  session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css">
    <style>
      body{
        width: 70%;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
      }
    </style>
  </head>
  <body>
   <?php

   try{

   require_once('../common/common.php');

   $post=sanitize($_POST);

   $onamae=$post['onamae'];
   $email=$post['email'];
   $postal1=$post['postal1'];
   $postal2=$post['postal2'];
   $address=$post['address'];
   $tel=$post['tel'];
   $chumon=$post['chumon'];
   $pass=$post['pass'];
   $danjo=$post['danjo'];
   $birth=$post['birth'];

   print$onamae.'様<br/>';
   print'ご注文ありがとうございました。<br/>';
   print$email.'にメールを送りましたのでご確認ください。<br/>';
   print'商品は以下の住所に発送させていただきます。<br/><br/>';
   print$postal1.'-'.$postal2.'<br/>';
   print$address.'<br/>';
   print$tel.'<br/><br/>';

   $honbun='';
   $honbun.=$onamae."様 \n\n このたびはご注文ありがとうございました。 \n";
   $honbun.="\n";
   $honbun.="ご注文商品 \n";
   $honbun.="--------------------\n";

   $cart=$_SESSION['cart'];
   $kazu=$_SESSION['kazu'];
   $max=count($cart);

   $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
   $user='root';
   $password='root';
   $dbh=new PDO($dsn, $user, $password);
   $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

   for($i=0;$i<$max;$i++){
    $sql='SELECT name,price FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[0]=$cart[$i];
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

    $name=$rec['name'];
    $price=$rec['price'];
    $kakaku[]=$price;
    $suryo=$kazu[$i];
    $shokei=$price*$suryo;

    $honbun.=$name.' ';
    $honbun.=$price.'円 x ';
    $honbun.=$suryo.'個 = ';
    $honbun.=$shokei.'円　';
   }

   $sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE,dat_member WRITE';
   $stmt=$dbh->prepare($sql);
   $stmt->execute();

   $dbh->beginTransaction();

   $lastmembercode=0;
   if($chumon=='chumontouroku'){
     $sql='INSERT INTO dat_member (password,name,email,postal1,postal2,address,tel,danjo,born) VALUES (?,?,?,?,?,?,?,?,?)';
    $stmt=$dbh->prepare($sql);
    $data=array();
    $data[]=md5($pass);
    $data[]=$onamae;
    $data[]=$email;
    $data[]=$postal1;
    $data[]=$postal2;
    $data[]=$address;
    $data[]=$tel;
    if($danjo=='dan'){
      $data[]=1;
    } else{
      $data[]=2;
    }
    $data[]=$birth;
    $stmt->execute($data);

    $sql='SELECT LAST_INSERT_ID()';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $lastmembercode=$rec['LAST_INSERT_ID()'];
   }

   $sql='INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
   $stmt=$dbh->prepare($sql);
   $data=array();
   $data[]=0;
   $data[]=$onamae;
   $data[]=$email;
   $data[]=$postal1;
   $data[]=$postal2;
   $data[]=$address;
   $data[]=$tel;
   $stmt->execute($data);

   $sql='SELECT LAST_INSERT_ID()';
   $stmt=$dbh->prepare($sql);
   $stmt->execute();
   $rec=$stmt->fetch(PDO::FETCH_ASSOC);
   $lastcode=$rec['LAST_INSERT_ID()'];

   for($i=0;$i<$max;$i++){
    $sql='INSERT INTO dat_sales_product (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
    $stmt=$dbh->prepare($sql);
    $data=array();
    $data[]=$lastmembercode;
    $data[]=$cart[$i];
    $data[]=$kakaku[$i];
    $data[]=$kazu[$i];
    $stmt->execute($data);
   }

   $dbh->commit();

   $sql='UNLOCK TABLES';
   $stmt=$dbh->prepare($sql);
   $stmt->execute();

   $dbh=null;

   if($chumon=='chumontouroku'){
    print'会員登録が完了いたしました。<br/>';
    print'次回からはメールアドレスとパスワードでログインしてください。<br/>';
    print'ご注文が簡単にできるようになります。<br/>';
    print'<br/>';
   }

   $honbun.="送料は無料です。 \n";
   $honbun.="--------------------\n";
   $honbun.="\n";
   $honbun.="代金は以下の口座にお振込ください。 \n";
   $honbun.="ろくまる銀行 やさい支店 普通口座 1234567\n";
   $honbun.="入金確認が取れ次第、梱包、発送させていただきます。 \n";
   $honbun.="\n";

   if($chumon=='chumontouroku'){
    $honbun.="会員とく録画完了いたしました。\n";
    $honbun.="次回からはメールアドレスとパスワードでログインしてください。\n";
    $honbun.="ご注文が簡単にできるようになります。\n";
    $honbun.="\n";
   }

   $honbun.="□□□□□□□□□□□□□□ \n";
   $honbun.="〜あんしん野菜のろくまる農園〜 \n";
   $honbun.="\n";
   $honbun.="〇〇県六丸郡六丸村 123-4\n";
   $honbun.="電話 090-6060-xxxx\n";
   $honbun.="メール info@rokumarunouen.co.jp\n";
   $honbun.="□□□□□□□□□□□□□□ \n";
   // print'<br/>';
   // print nl2br($honbun);

   $title='ご注文ありがとうございます。';
   $header='From:info@rokumarunouen.co.jp';
   $honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
   mb_language('Japanese');
   mb_internal_encoding('UTF-8');
   mb_send_mail($email,$title,$honbun,$header);

   $title='お客様からご注文がありました。';
   $header='From:'.$email;
   $honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
   mb_language('Japanese');
   mb_internal_encoding('UTF-8');
   mb_send_mail('info@rokumarunouen.co.jp',$title,$honbun,$header);

   }
   catch(Exception $e){
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    print 'エラー内容: ' . $e->getMessage();
    exit();
   }

   ?>

   <br/>
  <a class="btn" href="shop_list.php">商品画面へ</a>
  </body>
</html>
